<?php

namespace Tests\Feature;

use App\Models\IPs;
use App\Models\Locations;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Reseller;
use App\Models\Settings;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportResellerTest extends TestCase
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
        $this->provider = Providers::create(['name' => 'Test Reseller Provider']);
        $this->location = Locations::create(['name' => 'Test Location']);
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createResellerWithAllRelationships(string $id, string $mainDomain): Reseller
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 4, // Reseller hosting type
            'currency' => 'USD',
            'price' => 29.99,
            'term' => 1, // Monthly
            'as_usd' => 29.99,
            'usd_per_month' => 29.99,
            'next_due_date' => '2024-02-15'
        ]);

        $reseller = Reseller::create([
            'id' => $id,
            'main_domain' => $mainDomain,
            'reseller_type' => 'WHM',
            'accounts' => 15,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 200,
            'disk_type' => 'GB',
            'disk_as_gb' => 200,
            'bandwidth' => 2000,
            'domains_limit' => 100,
            'subdomains_limit' => 500,
            'ftp_limit' => 100,
            'email_limit' => 1000,
            'db_limit' => 100,
            'was_promo' => 0,
            'active' => 1,
            'owned_since' => '2023-06-01'
        ]);

        // Create IP addresses
        IPs::create([
            'id' => 'ip1' . $id,
            'service_id' => $id,
            'address' => '10.0.0.1',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        return $reseller;
    }

    /**
     * Test exportReseller returns correct structure for JSON format
     * Validates: Requirements 4.1
     */
    public function test_export_reseller_returns_correct_json_structure()
    {
        $this->createResellerWithAllRelationships('rs001', 'reseller.com');

        $result = $this->exportService->exportReseller('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('reseller_hosting_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportReseller returns correct structure for CSV format
     * Validates: Requirements 4.1
     */
    public function test_export_reseller_returns_correct_csv_structure()
    {
        $this->createResellerWithAllRelationships('rs002', 'reseller2.com');

        $result = $this->exportService->exportReseller('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('reseller_hosting_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportReseller includes all reseller hosting fields
     * Validates: Requirement 4.1
     */
    public function test_export_reseller_includes_all_reseller_hosting_fields()
    {
        $this->createResellerWithAllRelationships('rs003', 'testreseller.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $reseller = $data[0];

        // Check all required reseller hosting fields
        $this->assertEquals('rs003', $reseller['id']);
        $this->assertEquals('testreseller.com', $reseller['main_domain']);
        $this->assertEquals('WHM', $reseller['reseller_type']);
        $this->assertEquals(15, $reseller['accounts']);
        $this->assertEquals(200, $reseller['disk']);
        $this->assertEquals('GB', $reseller['disk_type']);
        $this->assertEquals(200, $reseller['disk_as_gb']);
        $this->assertEquals(2000, $reseller['bandwidth']);
        $this->assertEquals(100, $reseller['domains_limit']);
        $this->assertEquals(500, $reseller['subdomains_limit']);
        $this->assertEquals(100, $reseller['ftp_limit']);
        $this->assertEquals(1000, $reseller['email_limit']);
        $this->assertEquals(100, $reseller['db_limit']);
        $this->assertEquals(1, $reseller['active']);
        $this->assertEquals('2023-06-01', $reseller['owned_since']);
    }

    /**
     * Test exportReseller includes location relationship
     * Validates: Requirement 4.1
     */
    public function test_export_reseller_includes_location_relationship()
    {
        $this->createResellerWithAllRelationships('rs004', 'locationtest.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('location', $reseller);
        $this->assertNotNull($reseller['location']);
        $this->assertArrayHasKey('id', $reseller['location']);
        $this->assertArrayHasKey('name', $reseller['location']);
        $this->assertEquals('Test Location', $reseller['location']['name']);
    }

    /**
     * Test exportReseller includes provider relationship
     * Validates: Requirement 4.1
     */
    public function test_export_reseller_includes_provider_relationship()
    {
        $this->createResellerWithAllRelationships('rs005', 'providertest.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('provider', $reseller);
        $this->assertNotNull($reseller['provider']);
        $this->assertArrayHasKey('id', $reseller['provider']);
        $this->assertArrayHasKey('name', $reseller['provider']);
        $this->assertEquals('Test Reseller Provider', $reseller['provider']['name']);
    }

    /**
     * Test exportReseller includes pricing data
     * Validates: Requirement 4.2
     */
    public function test_export_reseller_includes_pricing_data()
    {
        $this->createResellerWithAllRelationships('rs006', 'pricingtest.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('pricing', $reseller);
        $this->assertNotNull($reseller['pricing']);
        $this->assertEquals(29.99, $reseller['pricing']['price']);
        $this->assertEquals('USD', $reseller['pricing']['currency']);
        $this->assertEquals(1, $reseller['pricing']['term']);
        $this->assertEquals('Monthly', $reseller['pricing']['term_name']);
        $this->assertEquals(29.99, $reseller['pricing']['as_usd']);
        $this->assertEquals(29.99, $reseller['pricing']['usd_per_month']);
        $this->assertEquals('2024-02-15', $reseller['pricing']['next_due_date']);
    }

    /**
     * Test exportReseller includes IP addresses
     * Validates: Requirement 4.3
     */
    public function test_export_reseller_includes_ip_addresses()
    {
        $this->createResellerWithAllRelationships('rs007', 'iptest.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('ips', $reseller);
        $this->assertCount(1, $reseller['ips']);
        $this->assertEquals('10.0.0.1', $reseller['ips'][0]['address']);
        $this->assertEquals(1, $reseller['ips'][0]['is_ipv4']);
    }

    /**
     * Test exportReseller returns valid JSON
     * Validates: Requirement 8.1
     */
    public function test_export_reseller_returns_valid_json()
    {
        $this->createResellerWithAllRelationships('rs008', 'validjson.com');

        $result = $this->exportService->exportReseller('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportReseller JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_reseller_json_uses_pretty_print()
    {
        $this->createResellerWithAllRelationships('rs009', 'prettyprint.com');

        $result = $this->exportService->exportReseller('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportReseller CSV has proper headers
     * Validates: Requirement 8.2
     */
    public function test_export_reseller_csv_has_proper_headers()
    {
        $this->createResellerWithAllRelationships('rs010', 'csvheaders.com');

        $result = $this->exportService->exportReseller('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('main_domain', $headers);
        $this->assertStringContainsString('reseller_type', $headers);
        $this->assertStringContainsString('accounts', $headers);
        $this->assertStringContainsString('disk', $headers);
        $this->assertStringContainsString('bandwidth', $headers);
        $this->assertStringContainsString('domains_limit', $headers);
        $this->assertStringContainsString('location_id', $headers);
        $this->assertStringContainsString('provider_id', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
    }

    /**
     * Test exportReseller handles empty database
     */
    public function test_export_reseller_handles_empty_database()
    {
        $result = $this->exportService->exportReseller('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportReseller handles reseller hosting without IPs
     */
    public function test_export_reseller_handles_reseller_without_ips()
    {
        // Create pricing first
        Pricing::create([
            'service_id' => 'rs011',
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 19.99,
            'term' => 1,
            'as_usd' => 19.99,
            'usd_per_month' => 19.99,
            'next_due_date' => '2024-02-15'
        ]);

        Reseller::create([
            'id' => 'rs011',
            'main_domain' => 'noips.com',
            'reseller_type' => 'DirectAdmin',
            'accounts' => 5,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 100,
            'disk_type' => 'GB',
            'disk_as_gb' => 100,
            'bandwidth' => 1000,
            'domains_limit' => 50,
            'subdomains_limit' => 250,
            'ftp_limit' => 50,
            'email_limit' => 500,
            'db_limit' => 50,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('ips', $reseller);
        $this->assertIsArray($reseller['ips']);
        $this->assertCount(0, $reseller['ips']);
    }

    /**
     * Test exportReseller handles multiple reseller hosting accounts
     */
    public function test_export_reseller_handles_multiple_reseller_hosting()
    {
        $this->createResellerWithAllRelationships('rs012', 'site1.com');
        $this->createResellerWithAllRelationships('rs013', 'site2.com');
        $this->createResellerWithAllRelationships('rs014', 'site3.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportReseller format is case-insensitive
     */
    public function test_export_reseller_format_is_case_insensitive()
    {
        $this->createResellerWithAllRelationships('rs015', 'casetest.com');

        $resultJson = $this->exportService->exportReseller('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportReseller('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportReseller CSV contains correct data
     * Validates: Requirement 8.2
     */
    public function test_export_reseller_csv_contains_correct_data()
    {
        $this->createResellerWithAllRelationships('rs016', 'csvdata.com');

        $result = $this->exportService->exportReseller('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('rs016', $lines[1]);
        $this->assertStringContainsString('csvdata.com', $lines[1]);
        $this->assertStringContainsString('WHM', $lines[1]);
    }

    /**
     * Test exportReseller includes multiple IPs when present
     */
    public function test_export_reseller_includes_multiple_ips()
    {
        $this->createResellerWithAllRelationships('rs017', 'multiip.com');

        // Add another IP
        IPs::create([
            'id' => 'ip2rs017',
            'service_id' => 'rs017',
            'address' => '10.0.0.50',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('ips', $reseller);
        $this->assertCount(2, $reseller['ips']);
    }

    /**
     * Test exportReseller includes accounts field (specific to reseller)
     * Validates: Requirement 4.1
     */
    public function test_export_reseller_includes_accounts_field()
    {
        $this->createResellerWithAllRelationships('rs018', 'accountstest.com');

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('accounts', $reseller);
        $this->assertEquals(15, $reseller['accounts']);
    }

    /**
     * Test exportReseller handles reseller without pricing (zero values)
     */
    public function test_export_reseller_handles_reseller_with_zero_pricing()
    {
        // Create pricing first (required by foreign key constraint) but with zero values
        Pricing::create([
            'service_id' => 'rs019',
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 0,
            'term' => 1,
            'as_usd' => 0,
            'usd_per_month' => 0,
            'next_due_date' => '2024-02-15'
        ]);

        Reseller::create([
            'id' => 'rs019',
            'main_domain' => 'nopricing.com',
            'reseller_type' => 'WHM',
            'accounts' => 10,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 150,
            'disk_type' => 'GB',
            'disk_as_gb' => 150,
            'bandwidth' => 1500,
            'domains_limit' => 75,
            'subdomains_limit' => 375,
            'ftp_limit' => 75,
            'email_limit' => 750,
            'db_limit' => 75,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        $result = $this->exportService->exportReseller('json');
        $data = json_decode($result['data'], true);
        $reseller = $data[0];

        $this->assertArrayHasKey('pricing', $reseller);
        // Pricing exists but with zero values
        $this->assertNotNull($reseller['pricing']);
        $this->assertEquals(0, $reseller['pricing']['price']);
    }
}
