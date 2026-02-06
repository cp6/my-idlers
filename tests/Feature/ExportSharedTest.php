<?php

namespace Tests\Feature;

use App\Models\IPs;
use App\Models\Locations;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Settings;
use App\Models\Shared;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportSharedTest extends TestCase
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
        $this->provider = Providers::create(['name' => 'Test Hosting Provider']);
        $this->location = Locations::create(['name' => 'Test Location']);
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createSharedWithAllRelationships(string $id, string $mainDomain): Shared
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 3, // Shared hosting type
            'currency' => 'USD',
            'price' => 5.99,
            'term' => 1, // Monthly
            'as_usd' => 5.99,
            'usd_per_month' => 5.99,
            'next_due_date' => '2024-02-15'
        ]);

        $shared = Shared::create([
            'id' => $id,
            'main_domain' => $mainDomain,
            'shared_type' => 'cPanel',
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 50,
            'disk_type' => 'GB',
            'disk_as_gb' => 50,
            'bandwidth' => 500,
            'domains_limit' => 10,
            'subdomains_limit' => 50,
            'ftp_limit' => 10,
            'email_limit' => 100,
            'db_limit' => 10,
            'was_promo' => 0,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        // Create IP addresses
        IPs::create([
            'id' => 'ip1' . $id,
            'service_id' => $id,
            'address' => '192.168.1.100',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        return $shared;
    }


    /**
     * Test exportShared returns correct structure for JSON format
     * Validates: Requirements 3.1
     */
    public function test_export_shared_returns_correct_json_structure()
    {
        $this->createSharedWithAllRelationships('sh001', 'mysite.com');

        $result = $this->exportService->exportShared('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('shared_hosting_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportShared returns correct structure for CSV format
     * Validates: Requirements 3.1
     */
    public function test_export_shared_returns_correct_csv_structure()
    {
        $this->createSharedWithAllRelationships('sh002', 'mysite2.com');

        $result = $this->exportService->exportShared('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('shared_hosting_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportShared includes all shared hosting fields
     * Validates: Requirement 3.1
     */
    public function test_export_shared_includes_all_shared_hosting_fields()
    {
        $this->createSharedWithAllRelationships('sh003', 'testsite.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $shared = $data[0];

        // Check all required shared hosting fields
        $this->assertEquals('sh003', $shared['id']);
        $this->assertEquals('testsite.com', $shared['main_domain']);
        $this->assertEquals('cPanel', $shared['shared_type']);
        $this->assertEquals(50, $shared['disk']);
        $this->assertEquals('GB', $shared['disk_type']);
        $this->assertEquals(50, $shared['disk_as_gb']);
        $this->assertEquals(500, $shared['bandwidth']);
        $this->assertEquals(10, $shared['domains_limit']);
        $this->assertEquals(50, $shared['subdomains_limit']);
        $this->assertEquals(10, $shared['ftp_limit']);
        $this->assertEquals(100, $shared['email_limit']);
        $this->assertEquals(10, $shared['db_limit']);
        $this->assertEquals(1, $shared['active']);
        $this->assertEquals('2024-01-01', $shared['owned_since']);
    }

    /**
     * Test exportShared includes location relationship
     * Validates: Requirement 3.1
     */
    public function test_export_shared_includes_location_relationship()
    {
        $this->createSharedWithAllRelationships('sh004', 'locationtest.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('location', $shared);
        $this->assertNotNull($shared['location']);
        $this->assertArrayHasKey('id', $shared['location']);
        $this->assertArrayHasKey('name', $shared['location']);
        $this->assertEquals('Test Location', $shared['location']['name']);
    }

    /**
     * Test exportShared includes provider relationship
     * Validates: Requirement 3.1
     */
    public function test_export_shared_includes_provider_relationship()
    {
        $this->createSharedWithAllRelationships('sh005', 'providertest.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('provider', $shared);
        $this->assertNotNull($shared['provider']);
        $this->assertArrayHasKey('id', $shared['provider']);
        $this->assertArrayHasKey('name', $shared['provider']);
        $this->assertEquals('Test Hosting Provider', $shared['provider']['name']);
    }

    /**
     * Test exportShared includes pricing data
     * Validates: Requirement 3.2
     */
    public function test_export_shared_includes_pricing_data()
    {
        $this->createSharedWithAllRelationships('sh006', 'pricingtest.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('pricing', $shared);
        $this->assertNotNull($shared['pricing']);
        $this->assertEquals(5.99, $shared['pricing']['price']);
        $this->assertEquals('USD', $shared['pricing']['currency']);
        $this->assertEquals(1, $shared['pricing']['term']);
        $this->assertEquals('Monthly', $shared['pricing']['term_name']);
        $this->assertEquals(5.99, $shared['pricing']['as_usd']);
        $this->assertEquals(5.99, $shared['pricing']['usd_per_month']);
        $this->assertEquals('2024-02-15', $shared['pricing']['next_due_date']);
    }

    /**
     * Test exportShared includes IP addresses
     * Validates: Requirement 3.3
     */
    public function test_export_shared_includes_ip_addresses()
    {
        $this->createSharedWithAllRelationships('sh007', 'iptest.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('ips', $shared);
        $this->assertCount(1, $shared['ips']);
        $this->assertEquals('192.168.1.100', $shared['ips'][0]['address']);
        $this->assertEquals(1, $shared['ips'][0]['is_ipv4']);
    }


    /**
     * Test exportShared returns valid JSON
     * Validates: Requirement 8.1
     */
    public function test_export_shared_returns_valid_json()
    {
        $this->createSharedWithAllRelationships('sh008', 'validjson.com');

        $result = $this->exportService->exportShared('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportShared JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_shared_json_uses_pretty_print()
    {
        $this->createSharedWithAllRelationships('sh009', 'prettyprint.com');

        $result = $this->exportService->exportShared('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportShared CSV has proper headers
     * Validates: Requirement 8.2
     */
    public function test_export_shared_csv_has_proper_headers()
    {
        $this->createSharedWithAllRelationships('sh010', 'csvheaders.com');

        $result = $this->exportService->exportShared('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('main_domain', $headers);
        $this->assertStringContainsString('shared_type', $headers);
        $this->assertStringContainsString('disk', $headers);
        $this->assertStringContainsString('bandwidth', $headers);
        $this->assertStringContainsString('domains_limit', $headers);
        $this->assertStringContainsString('location_id', $headers);
        $this->assertStringContainsString('provider_id', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
    }

    /**
     * Test exportShared handles empty database
     */
    public function test_export_shared_handles_empty_database()
    {
        $result = $this->exportService->exportShared('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportShared handles shared hosting without IPs
     */
    public function test_export_shared_handles_shared_without_ips()
    {
        // Create pricing first
        Pricing::create([
            'service_id' => 'sh011',
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 3.99,
            'term' => 1,
            'as_usd' => 3.99,
            'usd_per_month' => 3.99,
            'next_due_date' => '2024-02-15'
        ]);

        Shared::create([
            'id' => 'sh011',
            'main_domain' => 'noips.com',
            'shared_type' => 'DirectAdmin',
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'disk' => 25,
            'disk_type' => 'GB',
            'disk_as_gb' => 25,
            'bandwidth' => 250,
            'domains_limit' => 5,
            'subdomains_limit' => 25,
            'ftp_limit' => 5,
            'email_limit' => 50,
            'db_limit' => 5,
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('ips', $shared);
        $this->assertIsArray($shared['ips']);
        $this->assertCount(0, $shared['ips']);
    }

    /**
     * Test exportShared handles multiple shared hosting accounts
     */
    public function test_export_shared_handles_multiple_shared_hosting()
    {
        $this->createSharedWithAllRelationships('sh012', 'site1.com');
        $this->createSharedWithAllRelationships('sh013', 'site2.com');
        $this->createSharedWithAllRelationships('sh014', 'site3.com');

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportShared format is case-insensitive
     */
    public function test_export_shared_format_is_case_insensitive()
    {
        $this->createSharedWithAllRelationships('sh015', 'casetest.com');

        $resultJson = $this->exportService->exportShared('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportShared('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportShared CSV contains correct data
     * Validates: Requirement 8.2
     */
    public function test_export_shared_csv_contains_correct_data()
    {
        $this->createSharedWithAllRelationships('sh016', 'csvdata.com');

        $result = $this->exportService->exportShared('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('sh016', $lines[1]);
        $this->assertStringContainsString('csvdata.com', $lines[1]);
        $this->assertStringContainsString('cPanel', $lines[1]);
    }

    /**
     * Test exportShared includes multiple IPs when present
     */
    public function test_export_shared_includes_multiple_ips()
    {
        $shared = $this->createSharedWithAllRelationships('sh017', 'multiip.com');

        // Add another IP
        IPs::create([
            'id' => 'ip2sh017',
            'service_id' => 'sh017',
            'address' => '10.0.0.50',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        $result = $this->exportService->exportShared('json');
        $data = json_decode($result['data'], true);
        $shared = $data[0];

        $this->assertArrayHasKey('ips', $shared);
        $this->assertCount(2, $shared['ips']);
    }
}
