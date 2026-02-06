<?php

namespace Tests\Feature;

use App\Models\DiskSpeed;
use App\Models\DNS;
use App\Models\Domains;
use App\Models\IPs;
use App\Models\Locations;
use App\Models\Misc;
use App\Models\NetworkSpeed;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Reseller;
use App\Models\SeedBoxes;
use App\Models\Server;
use App\Models\Settings;
use App\Models\Shared;
use App\Models\User;
use App\Models\Yabs;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ZipArchive;

class ExportAllTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Providers $provider;
    protected Locations $location;
    protected OS $os;
    protected ExportService $exportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->provider = Providers::create(['name' => 'Test Provider']);
        $this->location = Locations::create(['name' => 'Test Location']);
        $this->os = OS::create(['name' => 'Ubuntu 22.04']);
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createServer(string $id, string $hostname): Server
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 10.00,
            'term' => 1,
            'as_usd' => 10.00,
            'usd_per_month' => 10.00,
            'next_due_date' => '2024-02-15'
        ]);

        return Server::create([
            'id' => $id,
            'hostname' => $hostname,
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 8,
            'ram_type' => 'GB',
            'ram_as_mb' => 8192,
            'disk' => 100,
            'disk_type' => 'GB',
            'disk_as_gb' => 100,
            'bandwidth' => 1000,
            'ssh' => 22,
            'cpu' => 4,
            'active' => 1,
            'owned_since' => '2024-01-15'
        ]);
    }

    protected function createDomain(string $id, string $domain): Domains
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 12.00,
            'term' => 4,
            'as_usd' => 12.00,
            'usd_per_month' => 1.00,
            'next_due_date' => '2024-06-01'
        ]);

        return Domains::create([
            'id' => $id,
            'domain' => $domain,
            'extension' => 'com',
            'ns1' => 'ns1.example.com',
            'ns2' => 'ns2.example.com',
            'provider_id' => $this->provider->id,
            'owned_since' => '2023-06-01'
        ]);
    }

    protected function createShared(string $id, string $mainDomain): Shared
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 3,
            'currency' => 'USD',
            'price' => 5.99,
            'term' => 1,
            'as_usd' => 5.99,
            'usd_per_month' => 5.99,
            'next_due_date' => '2024-02-01'
        ]);

        return Shared::create([
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
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);
    }

    protected function createReseller(string $id, string $mainDomain): Reseller
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 4,
            'currency' => 'USD',
            'price' => 29.99,
            'term' => 1,
            'as_usd' => 29.99,
            'usd_per_month' => 29.99,
            'next_due_date' => '2024-02-01'
        ]);

        return Reseller::create([
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
            'active' => 1,
            'owned_since' => '2023-06-01'
        ]);
    }

    protected function createSeedbox(string $id, string $title): SeedBoxes
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 5,
            'currency' => 'EUR',
            'price' => 15.00,
            'term' => 1,
            'as_usd' => 16.50,
            'usd_per_month' => 16.50,
            'next_due_date' => '2024-02-01'
        ]);

        return SeedBoxes::create([
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
            'active' => 1,
            'owned_since' => '2024-01-01'
        ]);
    }

    protected function createDns(string $id, string $hostname): DNS
    {
        return DNS::create([
            'id' => $id,
            'hostname' => $hostname,
            'dns_type' => 'A',
            'address' => '192.168.1.1'
        ]);
    }

    protected function createMisc(string $id, string $name): Misc
    {
        Pricing::create([
            'service_id' => $id,
            'service_type' => 7,
            'currency' => 'USD',
            'price' => 50.00,
            'term' => 4,
            'as_usd' => 50.00,
            'usd_per_month' => 4.17,
            'next_due_date' => '2025-01-01'
        ]);

        return Misc::create([
            'id' => $id,
            'name' => $name,
            'owned_since' => '2024-01-01'
        ]);
    }

    /**
     * Test exportAll returns correct structure for JSON format
     * Validates: Requirements 10.2, 10.4
     */
    public function test_export_all_returns_correct_json_structure()
    {
        $this->createServer('srv001', 'server1.example.com');
        $this->createDomain('dom001', 'example');

        $result = $this->exportService->exportAll('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('my_idlers_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportAll JSON includes export_metadata
     * Validates: Requirement 10.4
     */
    public function test_export_all_json_includes_metadata()
    {
        $this->createServer('srv002', 'server2.example.com');
        $this->createDomain('dom002', 'example2');

        $result = $this->exportService->exportAll('json');
        $data = json_decode($result['data'], true);

        $this->assertArrayHasKey('export_metadata', $data);
        $this->assertArrayHasKey('export_date', $data['export_metadata']);
        $this->assertArrayHasKey('version', $data['export_metadata']);
        $this->assertArrayHasKey('counts', $data['export_metadata']);
        $this->assertEquals('4.1.0', $data['export_metadata']['version']);
    }

    /**
     * Test exportAll JSON includes correct service counts
     * Validates: Requirement 10.4
     */
    public function test_export_all_json_includes_correct_counts()
    {
        $this->createServer('srv003', 'server3.example.com');
        $this->createServer('srv004', 'server4.example.com');
        $this->createDomain('dom003', 'example3');
        $this->createShared('sh001', 'shared1.com');
        $this->createReseller('rs001', 'reseller1.com');
        $this->createSeedbox('sb001', 'My Seedbox');
        $this->createDns('dns001', 'mail.example.com');
        $this->createMisc('misc001', 'SSL Certificate');

        $result = $this->exportService->exportAll('json');
        $data = json_decode($result['data'], true);

        $counts = $data['export_metadata']['counts'];
        $this->assertEquals(2, $counts['servers']);
        $this->assertEquals(1, $counts['domains']);
        $this->assertEquals(1, $counts['shared']);
        $this->assertEquals(1, $counts['reseller']);
        $this->assertEquals(1, $counts['seedboxes']);
        $this->assertEquals(1, $counts['dns']);
        $this->assertEquals(1, $counts['misc']);
    }

    /**
     * Test exportAll JSON includes all service type sections
     * Validates: Requirement 10.2
     */
    public function test_export_all_json_includes_all_service_sections()
    {
        $this->createServer('srv005', 'server5.example.com');

        $result = $this->exportService->exportAll('json');
        $data = json_decode($result['data'], true);

        $this->assertArrayHasKey('servers', $data);
        $this->assertArrayHasKey('domains', $data);
        $this->assertArrayHasKey('shared', $data);
        $this->assertArrayHasKey('reseller', $data);
        $this->assertArrayHasKey('seedboxes', $data);
        $this->assertArrayHasKey('dns', $data);
        $this->assertArrayHasKey('misc', $data);
    }

    /**
     * Test exportAll JSON contains actual service data
     * Validates: Requirement 10.2
     */
    public function test_export_all_json_contains_service_data()
    {
        $this->createServer('srv006', 'server6.example.com');
        $this->createDomain('dom006', 'example6');

        $result = $this->exportService->exportAll('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data['servers']);
        $this->assertEquals('srv006', $data['servers'][0]['id']);
        $this->assertEquals('server6.example.com', $data['servers'][0]['hostname']);

        $this->assertCount(1, $data['domains']);
        $this->assertEquals('dom006', $data['domains'][0]['id']);
        $this->assertEquals('example6', $data['domains'][0]['domain']);
    }

    /**
     * Test exportAll returns valid JSON
     * Validates: Requirement 10.2
     */
    public function test_export_all_returns_valid_json()
    {
        $this->createServer('srv007', 'server7.example.com');

        $result = $this->exportService->exportAll('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportAll JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_all_json_uses_pretty_print()
    {
        $this->createServer('srv008', 'server8.example.com');

        $result = $this->exportService->exportAll('json');

        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportAll returns correct structure for CSV format (ZIP)
     * Validates: Requirement 10.3
     */
    public function test_export_all_returns_correct_csv_zip_structure()
    {
        $this->createServer('srv009', 'server9.example.com');

        $result = $this->exportService->exportAll('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/zip', $result['content_type']);
        $this->assertStringContainsString('my_idlers_export_', $result['filename']);
        $this->assertStringContainsString('.zip', $result['filename']);
    }

    /**
     * Test exportAll CSV ZIP contains separate CSV files for each service type
     * Validates: Requirement 10.3
     */
    public function test_export_all_csv_zip_contains_separate_csv_files()
    {
        $this->createServer('srv010', 'server10.example.com');
        $this->createDomain('dom010', 'example10');

        $result = $this->exportService->exportAll('csv');

        // Write ZIP to temp file and verify contents
        $tempFile = tempnam(sys_get_temp_dir(), 'test_export_');
        file_put_contents($tempFile, $result['data']);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($tempFile) === true);

        // Check for all expected CSV files
        $this->assertNotFalse($zip->locateName('servers.csv'));
        $this->assertNotFalse($zip->locateName('domains.csv'));
        $this->assertNotFalse($zip->locateName('shared_hosting.csv'));
        $this->assertNotFalse($zip->locateName('reseller_hosting.csv'));
        $this->assertNotFalse($zip->locateName('seedboxes.csv'));
        $this->assertNotFalse($zip->locateName('dns.csv'));
        $this->assertNotFalse($zip->locateName('misc_services.csv'));
        $this->assertNotFalse($zip->locateName('metadata.json'));

        $zip->close();
        unlink($tempFile);
    }

    /**
     * Test exportAll CSV ZIP contains valid CSV data
     * Validates: Requirement 10.3
     */
    public function test_export_all_csv_zip_contains_valid_csv_data()
    {
        $this->createServer('srv011', 'server11.example.com');

        $result = $this->exportService->exportAll('csv');

        $tempFile = tempnam(sys_get_temp_dir(), 'test_export_');
        file_put_contents($tempFile, $result['data']);

        $zip = new ZipArchive();
        $zip->open($tempFile);

        $serversCsv = $zip->getFromName('servers.csv');
        $this->assertNotFalse($serversCsv);
        $this->assertStringContainsString('id', $serversCsv);
        $this->assertStringContainsString('hostname', $serversCsv);
        $this->assertStringContainsString('srv011', $serversCsv);
        $this->assertStringContainsString('server11.example.com', $serversCsv);

        $zip->close();
        unlink($tempFile);
    }

    /**
     * Test exportAll CSV ZIP includes metadata.json
     * Validates: Requirement 10.4
     */
    public function test_export_all_csv_zip_includes_metadata()
    {
        $this->createServer('srv012', 'server12.example.com');
        $this->createDomain('dom012', 'example12');

        $result = $this->exportService->exportAll('csv');

        $tempFile = tempnam(sys_get_temp_dir(), 'test_export_');
        file_put_contents($tempFile, $result['data']);

        $zip = new ZipArchive();
        $zip->open($tempFile);

        $metadataJson = $zip->getFromName('metadata.json');
        $this->assertNotFalse($metadataJson);

        $metadata = json_decode($metadataJson, true);
        $this->assertArrayHasKey('export_date', $metadata);
        $this->assertArrayHasKey('version', $metadata);
        $this->assertArrayHasKey('counts', $metadata);
        $this->assertEquals('4.1.0', $metadata['version']);
        $this->assertEquals(1, $metadata['counts']['servers']);
        $this->assertEquals(1, $metadata['counts']['domains']);

        $zip->close();
        unlink($tempFile);
    }

    /**
     * Test exportAll handles empty database
     */
    public function test_export_all_handles_empty_database()
    {
        $result = $this->exportService->exportAll('json');

        $this->assertJson($result['data']);
        $data = json_decode($result['data'], true);

        $this->assertEquals(0, $data['export_metadata']['counts']['servers']);
        $this->assertEquals(0, $data['export_metadata']['counts']['domains']);
        $this->assertCount(0, $data['servers']);
        $this->assertCount(0, $data['domains']);
    }

    /**
     * Test exportAll format is case-insensitive
     */
    public function test_export_all_format_is_case_insensitive()
    {
        $this->createServer('srv013', 'server13.example.com');

        $resultJson = $this->exportService->exportAll('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportAll('CSV');
        $this->assertEquals('application/zip', $resultCsv['content_type']);
    }

    /**
     * Test exportAll export_date is in ISO 8601 format
     * Validates: Requirement 10.4
     */
    public function test_export_all_export_date_is_iso_8601()
    {
        $this->createServer('srv014', 'server14.example.com');

        $result = $this->exportService->exportAll('json');
        $data = json_decode($result['data'], true);

        $exportDate = $data['export_metadata']['export_date'];
        // ISO 8601 format should be parseable by DateTime
        $dateTime = \DateTime::createFromFormat(\DateTime::ATOM, $exportDate);
        $this->assertNotFalse($dateTime);
    }
}
