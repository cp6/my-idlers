<?php

namespace Tests\Feature;

use App\Models\Domains;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Settings;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportDomainsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Providers $provider;
    protected ExportService $exportService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->provider = Providers::create(['name' => 'Test Registrar']);
        Settings::create(['id' => 1]);
        $this->exportService = new ExportService();
    }

    protected function createDomainWithPricing(string $id, string $domain, string $extension): Domains
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 2, // Domain type
            'currency' => 'USD',
            'price' => 12.00,
            'term' => 4, // Yearly
            'as_usd' => 12.00,
            'usd_per_month' => 1.00,
            'next_due_date' => '2025-01-15'
        ]);

        return Domains::create([
            'id' => $id,
            'domain' => $domain,
            'extension' => $extension,
            'ns1' => 'ns1.example.com',
            'ns2' => 'ns2.example.com',
            'ns3' => 'ns3.example.com',
            'provider_id' => $this->provider->id,
            'owned_since' => '2024-01-15'
        ]);
    }

    /**
     * Test exportDomains returns correct structure for JSON format
     * Validates: Requirements 2.1, 2.3
     */
    public function test_export_domains_returns_correct_json_structure()
    {
        $this->createDomainWithPricing('dom001', 'example', 'com');

        $result = $this->exportService->exportDomains('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('domains_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportDomains returns correct structure for CSV format
     * Validates: Requirements 2.1, 2.4
     */
    public function test_export_domains_returns_correct_csv_structure()
    {
        $this->createDomainWithPricing('dom002', 'example', 'org');

        $result = $this->exportService->exportDomains('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('domains_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportDomains includes all domain fields
     * Validates: Requirement 2.1
     */
    public function test_export_domains_includes_all_domain_fields()
    {
        $this->createDomainWithPricing('dom003', 'testdomain', 'net');

        $result = $this->exportService->exportDomains('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $domain = $data[0];

        // Check all required domain fields
        $this->assertEquals('dom003', $domain['id']);
        $this->assertEquals('testdomain', $domain['domain']);
        $this->assertEquals('net', $domain['extension']);
        $this->assertEquals('testdomain.net', $domain['full_domain']);
        $this->assertEquals('ns1.example.com', $domain['ns1']);
        $this->assertEquals('ns2.example.com', $domain['ns2']);
        $this->assertEquals('ns3.example.com', $domain['ns3']);
        $this->assertEquals('2024-01-15', $domain['owned_since']);
    }

    /**
     * Test exportDomains includes provider relationship
     * Validates: Requirement 2.1
     */
    public function test_export_domains_includes_provider_relationship()
    {
        $this->createDomainWithPricing('dom004', 'mydomain', 'io');

        $result = $this->exportService->exportDomains('json');
        $data = json_decode($result['data'], true);
        $domain = $data[0];

        $this->assertArrayHasKey('provider', $domain);
        $this->assertNotNull($domain['provider']);
        $this->assertArrayHasKey('id', $domain['provider']);
        $this->assertArrayHasKey('name', $domain['provider']);
        $this->assertEquals('Test Registrar', $domain['provider']['name']);
    }

    /**
     * Test exportDomains includes pricing data
     * Validates: Requirement 2.2
     */
    public function test_export_domains_includes_pricing_data()
    {
        $this->createDomainWithPricing('dom005', 'priceddomain', 'com');

        $result = $this->exportService->exportDomains('json');
        $data = json_decode($result['data'], true);
        $domain = $data[0];

        $this->assertArrayHasKey('pricing', $domain);
        $this->assertNotNull($domain['pricing']);
        $this->assertEquals(12.00, $domain['pricing']['price']);
        $this->assertEquals('USD', $domain['pricing']['currency']);
        $this->assertEquals(4, $domain['pricing']['term']);
        $this->assertEquals('Yearly', $domain['pricing']['term_name']);
        $this->assertEquals(12.00, $domain['pricing']['as_usd']);
        $this->assertEquals(1.00, $domain['pricing']['usd_per_month']);
        $this->assertEquals('2025-01-15', $domain['pricing']['next_due_date']);
    }

    /**
     * Test exportDomains returns valid JSON
     * Validates: Requirement 2.3
     */
    public function test_export_domains_returns_valid_json()
    {
        $this->createDomainWithPricing('dom006', 'validjson', 'com');

        $result = $this->exportService->exportDomains('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportDomains JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_domains_json_uses_pretty_print()
    {
        $this->createDomainWithPricing('dom007', 'prettyprint', 'com');

        $result = $this->exportService->exportDomains('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportDomains CSV has proper headers
     * Validates: Requirement 2.4
     */
    public function test_export_domains_csv_has_proper_headers()
    {
        $this->createDomainWithPricing('dom008', 'csvheaders', 'com');

        $result = $this->exportService->exportDomains('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('domain', $headers);
        $this->assertStringContainsString('extension', $headers);
        $this->assertStringContainsString('full_domain', $headers);
        $this->assertStringContainsString('ns1', $headers);
        $this->assertStringContainsString('ns2', $headers);
        $this->assertStringContainsString('ns3', $headers);
        $this->assertStringContainsString('owned_since', $headers);
        $this->assertStringContainsString('provider_id', $headers);
        $this->assertStringContainsString('provider_name', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
    }

    /**
     * Test exportDomains handles empty database
     */
    public function test_export_domains_handles_empty_database()
    {
        $result = $this->exportService->exportDomains('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportDomains handles domain without ns3
     */
    public function test_export_domains_handles_domain_without_ns3()
    {
        // Create pricing first
        Pricing::create([
            'service_id' => 'dom009',
            'service_type' => 2,
            'currency' => 'USD',
            'price' => 10.00,
            'term' => 4,
            'as_usd' => 10.00,
            'usd_per_month' => 0.83,
            'next_due_date' => '2025-01-15'
        ]);

        Domains::create([
            'id' => 'dom009',
            'domain' => 'twons',
            'extension' => 'com',
            'ns1' => 'ns1.example.com',
            'ns2' => 'ns2.example.com',
            'ns3' => null,
            'provider_id' => $this->provider->id,
            'owned_since' => '2024-01-15'
        ]);

        $result = $this->exportService->exportDomains('json');
        $data = json_decode($result['data'], true);
        $domain = $data[0];

        $this->assertArrayHasKey('ns3', $domain);
        $this->assertNull($domain['ns3']);
    }

    /**
     * Test exportDomains handles multiple domains
     */
    public function test_export_domains_handles_multiple_domains()
    {
        $this->createDomainWithPricing('dom010', 'domain1', 'com');
        $this->createDomainWithPricing('dom011', 'domain2', 'org');
        $this->createDomainWithPricing('dom012', 'domain3', 'net');

        $result = $this->exportService->exportDomains('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportDomains format is case-insensitive
     */
    public function test_export_domains_format_is_case_insensitive()
    {
        $this->createDomainWithPricing('dom013', 'casetest', 'com');

        $resultJson = $this->exportService->exportDomains('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportDomains('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportDomains CSV contains correct data
     * Validates: Requirement 2.4
     */
    public function test_export_domains_csv_contains_correct_data()
    {
        $this->createDomainWithPricing('dom014', 'csvdata', 'com');

        $result = $this->exportService->exportDomains('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('dom014', $lines[1]);
        $this->assertStringContainsString('csvdata', $lines[1]);
        $this->assertStringContainsString('csvdata.com', $lines[1]);
    }
}
