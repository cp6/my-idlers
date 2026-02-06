<?php

namespace Tests\Unit;

use App\Services\ExportService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ExportServiceTest extends TestCase
{
    protected ExportService $exportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->exportService = new ExportService();
    }

    /**
     * Helper method to call protected methods
     */
    protected function callProtectedMethod($object, string $method, array $args = [])
    {
        $reflection = new ReflectionClass($object);
        $method = $reflection->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    // ==================== isValidFormat Tests ====================

    public function test_is_valid_format_returns_true_for_json()
    {
        $this->assertTrue($this->exportService->isValidFormat('json'));
    }

    public function test_is_valid_format_returns_true_for_csv()
    {
        $this->assertTrue($this->exportService->isValidFormat('csv'));
    }

    public function test_is_valid_format_returns_true_for_uppercase_json()
    {
        $this->assertTrue($this->exportService->isValidFormat('JSON'));
    }

    public function test_is_valid_format_returns_true_for_uppercase_csv()
    {
        $this->assertTrue($this->exportService->isValidFormat('CSV'));
    }

    public function test_is_valid_format_returns_true_for_mixed_case()
    {
        $this->assertTrue($this->exportService->isValidFormat('Json'));
        $this->assertTrue($this->exportService->isValidFormat('Csv'));
    }

    public function test_is_valid_format_returns_false_for_invalid_format()
    {
        $this->assertFalse($this->exportService->isValidFormat('xml'));
        $this->assertFalse($this->exportService->isValidFormat('pdf'));
        $this->assertFalse($this->exportService->isValidFormat(''));
        $this->assertFalse($this->exportService->isValidFormat('excel'));
    }

    // ==================== toJson Tests ====================

    public function test_to_json_returns_valid_json_from_array()
    {
        $data = [
            ['id' => 1, 'name' => 'Test'],
            ['id' => 2, 'name' => 'Test2']
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toJson', [$data]);

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals($data, $decoded);
    }

    public function test_to_json_returns_valid_json_from_collection()
    {
        $data = collect([
            ['id' => 1, 'name' => 'Test'],
            ['id' => 2, 'name' => 'Test2']
        ]);

        $result = $this->callProtectedMethod($this->exportService, 'toJson', [$data]);

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals($data->toArray(), $decoded);
    }

    public function test_to_json_uses_pretty_print_formatting()
    {
        $data = [['id' => 1, 'name' => 'Test']];

        $result = $this->callProtectedMethod($this->exportService, 'toJson', [$data]);

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result);
        $this->assertStringContainsString('    ', $result);
    }

    public function test_to_json_handles_nested_data()
    {
        $data = [
            [
                'id' => 1,
                'pricing' => [
                    'price' => 10.00,
                    'currency' => 'USD'
                ]
            ]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toJson', [$data]);

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals(10.00, $decoded[0]['pricing']['price']);
    }

    public function test_to_json_handles_empty_array()
    {
        $result = $this->callProtectedMethod($this->exportService, 'toJson', [[]]);

        $this->assertJson($result);
        $this->assertEquals('[]', $result);
    }

    public function test_to_json_handles_unicode_characters()
    {
        $data = [['name' => 'Tëst Üñíçödé']];

        $result = $this->callProtectedMethod($this->exportService, 'toJson', [$data]);

        $this->assertJson($result);
        // Unicode should not be escaped
        $this->assertStringContainsString('Tëst Üñíçödé', $result);
    }

    // ==================== toCsv Tests ====================

    public function test_to_csv_returns_csv_with_headers()
    {
        $data = [
            ['id' => 1, 'name' => 'Test'],
            ['id' => 2, 'name' => 'Test2']
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        $lines = explode("\n", $result);
        $this->assertCount(3, $lines); // header + 2 data rows
        $this->assertStringContainsString('id', $lines[0]);
        $this->assertStringContainsString('name', $lines[0]);
    }

    public function test_to_csv_escapes_commas_in_values()
    {
        $data = [
            ['id' => 1, 'name' => 'Test, with comma']
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        // Value with comma should be quoted
        $this->assertStringContainsString('"Test, with comma"', $result);
    }

    public function test_to_csv_escapes_double_quotes_in_values()
    {
        $data = [
            ['id' => 1, 'name' => 'Test "quoted" value']
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        // Double quotes should be escaped by doubling them
        $this->assertStringContainsString('"Test ""quoted"" value"', $result);
    }

    public function test_to_csv_escapes_newlines_in_values()
    {
        $data = [
            ['id' => 1, 'name' => "Test\nwith\nnewlines"]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        // Value with newlines should be quoted
        $this->assertStringContainsString('"Test', $result);
    }

    public function test_to_csv_handles_empty_array()
    {
        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [[]]);

        $this->assertEquals('', $result);
    }

    public function test_to_csv_handles_collection()
    {
        $data = collect([
            ['id' => 1, 'name' => 'Test']
        ]);

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('name', $result);
        $this->assertStringContainsString('Test', $result);
    }

    public function test_to_csv_handles_null_values()
    {
        $data = [
            ['id' => 1, 'name' => null]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        $lines = explode("\n", $result);
        $this->assertCount(2, $lines);
        // Null should be converted to empty string
        $this->assertEquals('1,', $lines[1]);
    }

    public function test_to_csv_handles_boolean_values()
    {
        $data = [
            ['id' => 1, 'active' => true, 'deleted' => false]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data]);

        $lines = explode("\n", $result);
        // Booleans should be converted to 1/0
        $this->assertStringContainsString('1', $lines[1]);
        $this->assertStringContainsString('0', $lines[1]);
    }

    public function test_to_csv_with_custom_headers()
    {
        $data = [
            ['id' => 1, 'name' => 'Test', 'extra' => 'value']
        ];
        $headers = ['id', 'name'];

        $result = $this->callProtectedMethod($this->exportService, 'toCsv', [$data, $headers]);

        $lines = explode("\n", $result);
        $this->assertEquals('id,name', $lines[0]);
    }

    // ==================== flattenForCsv Tests ====================

    public function test_flatten_for_csv_returns_flat_array_for_simple_data()
    {
        $data = ['id' => 1, 'name' => 'Test'];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        $this->assertEquals(['id' => 1, 'name' => 'Test'], $result);
    }

    public function test_flatten_for_csv_flattens_nested_associative_array()
    {
        $data = [
            'id' => 1,
            'pricing' => [
                'price' => 10.00,
                'currency' => 'USD'
            ]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        $this->assertEquals(1, $result['id']);
        $this->assertEquals(10.00, $result['pricing_price']);
        $this->assertEquals('USD', $result['pricing_currency']);
    }

    public function test_flatten_for_csv_handles_deeply_nested_data()
    {
        $data = [
            'id' => 1,
            'level1' => [
                'level2' => [
                    'level3' => 'deep_value'
                ]
            ]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        $this->assertEquals('deep_value', $result['level1_level2_level3']);
    }

    public function test_flatten_for_csv_handles_indexed_array_of_scalars()
    {
        $data = [
            'id' => 1,
            'tags' => ['tag1', 'tag2', 'tag3']
        ];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        // Indexed array of scalars should be joined with semicolon
        $this->assertEquals('tag1;tag2;tag3', $result['tags']);
    }

    public function test_flatten_for_csv_handles_indexed_array_of_objects()
    {
        $data = [
            'id' => 1,
            'ips' => [
                ['address' => '192.168.1.1'],
                ['address' => '192.168.1.2']
            ]
        ];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        // Indexed array of objects should be JSON encoded
        $this->assertJson($result['ips']);
    }

    public function test_flatten_for_csv_with_prefix()
    {
        $data = ['price' => 10.00, 'currency' => 'USD'];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data, 'pricing']);

        $this->assertEquals(10.00, $result['pricing_price']);
        $this->assertEquals('USD', $result['pricing_currency']);
    }

    public function test_flatten_for_csv_handles_empty_array()
    {
        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [[]]);

        $this->assertEquals([], $result);
    }

    public function test_flatten_for_csv_handles_null_values()
    {
        $data = ['id' => 1, 'name' => null];

        $result = $this->callProtectedMethod($this->exportService, 'flattenForCsv', [$data]);

        $this->assertArrayHasKey('name', $result);
        $this->assertNull($result['name']);
    }
}
