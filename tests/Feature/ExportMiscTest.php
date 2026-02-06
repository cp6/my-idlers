<?php

namespace Tests\Feature;

use App\Models\Misc;
use App\Models\Pricing;
use App\Models\Settings;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportMiscTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected ExportService $exportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createMiscServiceWithPricing(
        string $id,
        string $name,
        ?string $ownedSince = null,
        float $price = 10.00,
        string $currency = 'USD',
        int $term = 1
    ): Misc {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 7, // Misc service type
            'price' => $price,
            'currency' => $currency,
            'term' => $term,
            'as_usd' => $price,
            'usd_per_month' => $price,
            'next_due_date' => '2024-02-01',
        ]);

        return Misc::create([
            'id' => $id,
            'name' => $name,
            'owned_since' => $ownedSince ?? '2024-01-01',
        ]);
    }

    /**
     * Test exportMisc returns correct structure for JSON format
     * Validates: Requirements 7.1
     */
    public function test_export_misc_returns_correct_json_structure()
    {
        $this->createMiscServiceWithPricing('misc001', 'SSL Certificate');

        $result = $this->exportService->exportMisc('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('misc_services_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportMisc returns correct structure for CSV format
     * Validates: Requirements 7.1
     */
    public function test_export_misc_returns_correct_csv_structure()
    {
        $this->createMiscServiceWithPricing('misc002', 'VPN Service');

        $result = $this->exportService->exportMisc('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('misc_services_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportMisc includes all misc service fields
     * Validates: Requirement 7.1
     */
    public function test_export_misc_includes_all_misc_fields()
    {
        $this->createMiscServiceWithPricing('misc003', 'Backup Service', '2024-03-15');

        $result = $this->exportService->exportMisc('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $misc = $data[0];

        // Check all required misc fields
        $this->assertEquals('misc003', $misc['id']);
        $this->assertEquals('Backup Service', $misc['name']);
        $this->assertEquals('2024-03-15', $misc['owned_since']);
    }

    /**
     * Test exportMisc includes pricing data when available
     * Validates: Requirement 7.2
     */
    public function test_export_misc_includes_pricing_data()
    {
        $this->createMiscServiceWithPricing('misc004', 'SSL Certificate', null, 50.00, 'USD', 4);

        $result = $this->exportService->exportMisc('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $miscData = $data[0];

        // Check pricing data is included
        $this->assertArrayHasKey('pricing', $miscData);
        $this->assertNotNull($miscData['pricing']);
        $this->assertEquals(50.00, $miscData['pricing']['price']);
        $this->assertEquals('USD', $miscData['pricing']['currency']);
        $this->assertEquals(4, $miscData['pricing']['term']);
        $this->assertEquals('Yearly', $miscData['pricing']['term_name']);
        $this->assertArrayHasKey('as_usd', $miscData['pricing']);
        $this->assertArrayHasKey('usd_per_month', $miscData['pricing']);
        $this->assertArrayHasKey('next_due_date', $miscData['pricing']);
    }

    /**
     * Test exportMisc returns valid JSON
     * Validates: Requirement 8.1
     */
    public function test_export_misc_returns_valid_json()
    {
        $this->createMiscServiceWithPricing('miscjsn', 'JSON Test Service');

        $result = $this->exportService->exportMisc('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportMisc JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_misc_json_uses_pretty_print()
    {
        $this->createMiscServiceWithPricing('miscprt', 'Pretty Print Service');

        $result = $this->exportService->exportMisc('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportMisc CSV has proper headers
     * Validates: Requirement 8.2
     */
    public function test_export_misc_csv_has_proper_headers()
    {
        $this->createMiscServiceWithPricing('misccsv', 'CSV Test Service');

        $result = $this->exportService->exportMisc('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('name', $headers);
        $this->assertStringContainsString('owned_since', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
        $this->assertStringContainsString('pricing_term', $headers);
    }

    /**
     * Test exportMisc handles empty database
     */
    public function test_export_misc_handles_empty_database()
    {
        $result = $this->exportService->exportMisc('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportMisc handles multiple misc services
     */
    public function test_export_misc_handles_multiple_services()
    {
        $this->createMiscServiceWithPricing('miscml1', 'Service 1');
        $this->createMiscServiceWithPricing('miscml2', 'Service 2');
        $this->createMiscServiceWithPricing('miscml3', 'Service 3');

        $result = $this->exportService->exportMisc('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportMisc format is case-insensitive
     */
    public function test_export_misc_format_is_case_insensitive()
    {
        $this->createMiscServiceWithPricing('misccas', 'Case Test Service');

        $resultJson = $this->exportService->exportMisc('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportMisc('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportMisc CSV contains correct data
     * Validates: Requirement 8.2
     */
    public function test_export_misc_csv_contains_correct_data()
    {
        $this->createMiscServiceWithPricing('miscdat', 'Data Test Service', '2024-06-15');

        $result = $this->exportService->exportMisc('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('miscdat', $lines[1]);
        $this->assertStringContainsString('Data Test Service', $lines[1]);
        $this->assertStringContainsString('2024-06-15', $lines[1]);
    }

    /**
     * Test exportMisc CSV includes pricing data
     * Validates: Requirements 7.2, 8.2
     */
    public function test_export_misc_csv_includes_pricing_data()
    {
        $this->createMiscServiceWithPricing('miscprc', 'Priced Service', null, 25.00, 'EUR', 1);

        $result = $this->exportService->exportMisc('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines);
        $this->assertStringContainsString('25', $lines[1]);
        $this->assertStringContainsString('EUR', $lines[1]);
    }

    /**
     * Test exportMisc handles special characters in name
     * Validates: Requirement 8.4
     */
    public function test_export_misc_handles_special_characters_in_name()
    {
        $specialName = 'Service with "quotes" and, commas';
        $this->createMiscServiceWithPricing('miscspc', $specialName);

        $result = $this->exportService->exportMisc('json');
        $data = json_decode($result['data'], true);

        $this->assertEquals($specialName, $data[0]['name']);
    }

    /**
     * Test exportMisc CSV escapes special characters
     * Validates: Requirement 8.4
     */
    public function test_export_misc_csv_escapes_special_characters()
    {
        $specialName = 'Service with, comma';
        $this->createMiscServiceWithPricing('miscesc', $specialName);

        $result = $this->exportService->exportMisc('csv');

        // Value with comma should be quoted
        $this->assertStringContainsString('"Service with, comma"', $result['data']);
    }

    /**
     * Test exportMisc includes all pricing term types
     * Validates: Requirement 7.2
     */
    public function test_export_misc_includes_all_pricing_term_types()
    {
        $terms = [
            1 => 'Monthly',
            2 => 'Quarterly',
            3 => 'Semi-Annually',
            4 => 'Yearly',
            5 => 'Biennially',
            6 => 'Triennially',
        ];

        foreach ($terms as $termId => $termName) {
            $miscId = "misctr{$termId}";
            $this->createMiscServiceWithPricing($miscId, "Service Term {$termId}", null, 10.00, 'USD', $termId);
        }

        $result = $this->exportService->exportMisc('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(6, $data);

        foreach ($data as $misc) {
            $termId = $misc['pricing']['term'];
            $this->assertEquals($terms[$termId], $misc['pricing']['term_name']);
        }
    }
}
