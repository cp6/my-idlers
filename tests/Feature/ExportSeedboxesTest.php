<?php

namespace Tests\Feature;

use App\Models\Locations;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\SeedBoxes;
use App\Models\Settings;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportSeedboxesTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Providers $provider;
    protected Locations $location;
    protected ExportService $exportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->provider = Providers::create(['name' => 'Test Seedbox Provider']);
        $this->location = Locations::create(['name' => 'Amsterdam']);
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createSeedboxWithAllRelationships(string $id, string $title): SeedBoxes
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 5, // Seedbox type
            'currency' => 'EUR',
            'price' => 15.00,
            'term' => 1, // Monthly
            'as_usd' => 16.50,
            'usd_per_month' => 16.50,
            'next_due_date' => '2024-02-01'
        ]);

        $seedbox = SeedBoxes::create([
            'id' => $id,
            'title' => $title,
            'hostname' => 'seedbox.example.com',
            'seed_box_type' => 'Dedicated',
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 2000,
            'disk_type' => 'GB',
            'disk_as_gb' => 2000,
            'bandwidth' => 10000,
            'port_speed' => 1000,
            'was_promo' => 0,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        return $seedbox;
    }

    /**
     * Test exportSeedboxes returns correct structure for JSON format
     * Validates: Requirements 5.1
     */
    public function test_export_seedboxes_returns_correct_json_structure()
    {
        $this->createSeedboxWithAllRelationships('sb001', 'My Seedbox');

        $result = $this->exportService->exportSeedboxes('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('seedboxes_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportSeedboxes returns correct structure for CSV format
     * Validates: Requirements 5.1
     */
    public function test_export_seedboxes_returns_correct_csv_structure()
    {
        $this->createSeedboxWithAllRelationships('sb002', 'My Seedbox 2');

        $result = $this->exportService->exportSeedboxes('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('seedboxes_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportSeedboxes includes all seedbox fields
     * Validates: Requirement 5.1
     */
    public function test_export_seedboxes_includes_all_seedbox_fields()
    {
        $this->createSeedboxWithAllRelationships('sb003', 'Test Seedbox');

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $seedbox = $data[0];

        // Check all required seedbox fields
        $this->assertEquals('sb003', $seedbox['id']);
        $this->assertEquals('Test Seedbox', $seedbox['title']);
        $this->assertEquals('seedbox.example.com', $seedbox['hostname']);
        $this->assertEquals('Dedicated', $seedbox['seed_box_type']);
        $this->assertEquals(2000, $seedbox['disk']);
        $this->assertEquals('GB', $seedbox['disk_type']);
        $this->assertEquals(2000, $seedbox['disk_as_gb']);
        $this->assertEquals(10000, $seedbox['bandwidth']);
        $this->assertEquals(1000, $seedbox['port_speed']);
        $this->assertEquals(1, $seedbox['active']);
        $this->assertEquals('2024-01-01', $seedbox['owned_since']);
    }

    /**
     * Test exportSeedboxes includes location relationship
     * Validates: Requirement 5.1
     */
    public function test_export_seedboxes_includes_location_relationship()
    {
        $this->createSeedboxWithAllRelationships('sb004', 'Location Test');

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);
        $seedbox = $data[0];

        $this->assertArrayHasKey('location', $seedbox);
        $this->assertNotNull($seedbox['location']);
        $this->assertArrayHasKey('id', $seedbox['location']);
        $this->assertArrayHasKey('name', $seedbox['location']);
        $this->assertEquals('Amsterdam', $seedbox['location']['name']);
    }

    /**
     * Test exportSeedboxes includes provider relationship
     * Validates: Requirement 5.1
     */
    public function test_export_seedboxes_includes_provider_relationship()
    {
        $this->createSeedboxWithAllRelationships('sb005', 'Provider Test');

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);
        $seedbox = $data[0];

        $this->assertArrayHasKey('provider', $seedbox);
        $this->assertNotNull($seedbox['provider']);
        $this->assertArrayHasKey('id', $seedbox['provider']);
        $this->assertArrayHasKey('name', $seedbox['provider']);
        $this->assertEquals('Test Seedbox Provider', $seedbox['provider']['name']);
    }

    /**
     * Test exportSeedboxes includes pricing data
     * Validates: Requirement 5.2
     */
    public function test_export_seedboxes_includes_pricing_data()
    {
        $this->createSeedboxWithAllRelationships('sb006', 'Pricing Test');

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);
        $seedbox = $data[0];

        $this->assertArrayHasKey('pricing', $seedbox);
        $this->assertNotNull($seedbox['pricing']);
        $this->assertEquals(15.00, $seedbox['pricing']['price']);
        $this->assertEquals('EUR', $seedbox['pricing']['currency']);
        $this->assertEquals(1, $seedbox['pricing']['term']);
        $this->assertEquals('Monthly', $seedbox['pricing']['term_name']);
        $this->assertEquals(16.50, $seedbox['pricing']['as_usd']);
        $this->assertEquals(16.50, $seedbox['pricing']['usd_per_month']);
        $this->assertEquals('2024-02-01', $seedbox['pricing']['next_due_date']);
    }

    /**
     * Test exportSeedboxes returns valid JSON
     * Validates: Requirement 8.1
     */
    public function test_export_seedboxes_returns_valid_json()
    {
        $this->createSeedboxWithAllRelationships('sb007', 'Valid JSON Test');

        $result = $this->exportService->exportSeedboxes('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportSeedboxes JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_seedboxes_json_uses_pretty_print()
    {
        $this->createSeedboxWithAllRelationships('sb008', 'Pretty Print Test');

        $result = $this->exportService->exportSeedboxes('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportSeedboxes CSV has proper headers
     * Validates: Requirement 8.2
     */
    public function test_export_seedboxes_csv_has_proper_headers()
    {
        $this->createSeedboxWithAllRelationships('sb009', 'CSV Headers Test');

        $result = $this->exportService->exportSeedboxes('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('title', $headers);
        $this->assertStringContainsString('hostname', $headers);
        $this->assertStringContainsString('seed_box_type', $headers);
        $this->assertStringContainsString('disk', $headers);
        $this->assertStringContainsString('bandwidth', $headers);
        $this->assertStringContainsString('port_speed', $headers);
        $this->assertStringContainsString('location_id', $headers);
        $this->assertStringContainsString('provider_id', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
    }

    /**
     * Test exportSeedboxes handles empty database
     */
    public function test_export_seedboxes_handles_empty_database()
    {
        $result = $this->exportService->exportSeedboxes('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportSeedboxes handles multiple seedboxes
     */
    public function test_export_seedboxes_handles_multiple_seedboxes()
    {
        $this->createSeedboxWithAllRelationships('sb010', 'Seedbox 1');
        $this->createSeedboxWithAllRelationships('sb011', 'Seedbox 2');
        $this->createSeedboxWithAllRelationships('sb012', 'Seedbox 3');

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportSeedboxes format is case-insensitive
     */
    public function test_export_seedboxes_format_is_case_insensitive()
    {
        $this->createSeedboxWithAllRelationships('sb013', 'Case Test');

        $resultJson = $this->exportService->exportSeedboxes('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportSeedboxes('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportSeedboxes CSV contains correct data
     * Validates: Requirement 8.2
     */
    public function test_export_seedboxes_csv_contains_correct_data()
    {
        $this->createSeedboxWithAllRelationships('sb014', 'CSV Data Test');

        $result = $this->exportService->exportSeedboxes('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('sb014', $lines[1]);
        $this->assertStringContainsString('CSV Data Test', $lines[1]);
        $this->assertStringContainsString('Dedicated', $lines[1]);
    }

    /**
     * Test exportSeedboxes handles seedbox without pricing
     */
    public function test_export_seedboxes_handles_seedbox_without_pricing()
    {
        // Create seedbox without pricing
        SeedBoxes::create([
            'id' => 'sb015',
            'title' => 'No Pricing Seedbox',
            'hostname' => 'nopricing.example.com',
            'seed_box_type' => 'Shared',
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 500,
            'disk_type' => 'GB',
            'disk_as_gb' => 500,
            'bandwidth' => 5000,
            'port_speed' => 500,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);
        $seedbox = $data[0];

        $this->assertArrayHasKey('pricing', $seedbox);
        $this->assertNull($seedbox['pricing']);
    }

    /**
     * Test exportSeedboxes handles seedbox with zero pricing
     */
    public function test_export_seedboxes_handles_seedbox_with_zero_pricing()
    {
        // Create pricing with zero values
        Pricing::create([
            'service_id' => 'sb016',
            'service_type' => 5,
            'currency' => 'USD',
            'price' => 0,
            'term' => 1,
            'as_usd' => 0,
            'usd_per_month' => 0,
            'next_due_date' => '2024-02-01'
        ]);

        SeedBoxes::create([
            'id' => 'sb016',
            'title' => 'Zero Pricing Seedbox',
            'hostname' => 'zeropricing.example.com',
            'seed_box_type' => 'Shared',
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 500,
            'disk_type' => 'GB',
            'disk_as_gb' => 500,
            'bandwidth' => 5000,
            'port_speed' => 500,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        $result = $this->exportService->exportSeedboxes('json');
        $data = json_decode($result['data'], true);
        $seedbox = $data[0];

        $this->assertArrayHasKey('pricing', $seedbox);
        $this->assertNotNull($seedbox['pricing']);
        $this->assertEquals(0, $seedbox['pricing']['price']);
    }
}
