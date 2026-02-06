<?php

namespace Tests\Feature;

use App\Models\DNS;
use App\Models\Settings;
use App\Models\User;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportDnsTest extends TestCase
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

    protected function createDnsRecord(string $id, string $hostname, string $dnsType, string $address): DNS
    {
        return DNS::create([
            'id' => $id,
            'hostname' => $hostname,
            'dns_type' => $dnsType,
            'address' => $address,
            'server_id' => null,
            'domain_id' => null,
        ]);
    }

    /**
     * Test exportDns returns correct structure for JSON format
     * Validates: Requirements 6.1
     */
    public function test_export_dns_returns_correct_json_structure()
    {
        $this->createDnsRecord('dns001', 'mail.example.com', 'MX', 'mail.example.com');

        $result = $this->exportService->exportDns('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('dns_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportDns returns correct structure for CSV format
     * Validates: Requirements 6.1
     */
    public function test_export_dns_returns_correct_csv_structure()
    {
        $this->createDnsRecord('dns002', 'www.example.com', 'A', '192.168.1.1');

        $result = $this->exportService->exportDns('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('dns_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportDns includes all DNS record fields
     * Validates: Requirement 6.1
     */
    public function test_export_dns_includes_all_dns_fields()
    {
        $this->createDnsRecord('dns003', 'test.example.com', 'A', '10.0.0.1');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $dns = $data[0];

        // Check all required DNS fields
        $this->assertEquals('dns003', $dns['id']);
        $this->assertEquals('test.example.com', $dns['hostname']);
        $this->assertEquals('A', $dns['dns_type']);
        $this->assertEquals('10.0.0.1', $dns['address']);
        $this->assertArrayHasKey('server_id', $dns);
        $this->assertArrayHasKey('domain_id', $dns);
    }

    /**
     * Test exportDns supports A record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_a_record_type()
    {
        $this->createDnsRecord('dns-a', 'a.example.com', 'A', '192.168.1.1');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('A', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports AAAA record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_aaaa_record_type()
    {
        $this->createDnsRecord('dns-aaaa', 'aaaa.example.com', 'AAAA', '2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('AAAA', $data[0]['dns_type']);
        $this->assertEquals('2001:0db8:85a3:0000:0000:8a2e:0370:7334', $data[0]['address']);
    }

    /**
     * Test exportDns supports DNAME record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_dname_record_type()
    {
        $this->createDnsRecord('dns-dname', 'dname.example.com', 'DNAME', 'target.example.com');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('DNAME', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports MX record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_mx_record_type()
    {
        $this->createDnsRecord('dns-mx', 'mail.example.com', 'MX', 'mail.example.com');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('MX', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports NS record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_ns_record_type()
    {
        $this->createDnsRecord('dns-ns', 'ns1.example.com', 'NS', 'ns1.example.com');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('NS', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports SOA record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_soa_record_type()
    {
        $this->createDnsRecord('dns-soa', 'soa.example.com', 'SOA', 'ns1.example.com admin.example.com');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('SOA', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports TXT record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_txt_record_type()
    {
        $this->createDnsRecord('dns-txt', 'txt.example.com', 'TXT', 'v=spf1 include:_spf.example.com ~all');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('TXT', $data[0]['dns_type']);
        $this->assertEquals('v=spf1 include:_spf.example.com ~all', $data[0]['address']);
    }

    /**
     * Test exportDns supports URI record type
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_uri_record_type()
    {
        $this->createDnsRecord('dns-uri', 'uri.example.com', 'URI', 'https://example.com');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $this->assertEquals('URI', $data[0]['dns_type']);
    }

    /**
     * Test exportDns supports all DNS types in a single export
     * Validates: Requirement 6.2
     */
    public function test_export_dns_supports_all_dns_types()
    {
        $dnsTypes = ['A', 'AAAA', 'DNAME', 'MX', 'NS', 'SOA', 'TXT', 'URI'];
        
        foreach ($dnsTypes as $index => $type) {
            $this->createDnsRecord("dns-all-{$index}", "{$type}.example.com", $type, "address-{$type}");
        }

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(8, $data);
        
        $exportedTypes = array_column($data, 'dns_type');
        foreach ($dnsTypes as $type) {
            $this->assertContains($type, $exportedTypes, "DNS type {$type} should be in export");
        }
    }

    /**
     * Test exportDns returns valid JSON
     * Validates: Requirement 8.1
     */
    public function test_export_dns_returns_valid_json()
    {
        $this->createDnsRecord('dns-json', 'json.example.com', 'A', '192.168.1.1');

        $result = $this->exportService->exportDns('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportDns JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_dns_json_uses_pretty_print()
    {
        $this->createDnsRecord('dns-pretty', 'pretty.example.com', 'A', '192.168.1.1');

        $result = $this->exportService->exportDns('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportDns CSV has proper headers
     * Validates: Requirement 8.2
     */
    public function test_export_dns_csv_has_proper_headers()
    {
        $this->createDnsRecord('dns-csv', 'csv.example.com', 'A', '192.168.1.1');

        $result = $this->exportService->exportDns('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('hostname', $headers);
        $this->assertStringContainsString('dns_type', $headers);
        $this->assertStringContainsString('address', $headers);
        $this->assertStringContainsString('server_id', $headers);
        $this->assertStringContainsString('domain_id', $headers);
    }

    /**
     * Test exportDns handles empty database
     */
    public function test_export_dns_handles_empty_database()
    {
        $result = $this->exportService->exportDns('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportDns handles multiple DNS records
     */
    public function test_export_dns_handles_multiple_dns_records()
    {
        $this->createDnsRecord('dns-multi-1', 'record1.example.com', 'A', '192.168.1.1');
        $this->createDnsRecord('dns-multi-2', 'record2.example.com', 'MX', 'mail.example.com');
        $this->createDnsRecord('dns-multi-3', 'record3.example.com', 'TXT', 'some text');

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportDns format is case-insensitive
     */
    public function test_export_dns_format_is_case_insensitive()
    {
        $this->createDnsRecord('dns-case', 'case.example.com', 'A', '192.168.1.1');

        $resultJson = $this->exportService->exportDns('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportDns('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }

    /**
     * Test exportDns CSV contains correct data
     * Validates: Requirement 8.2
     */
    public function test_export_dns_csv_contains_correct_data()
    {
        $this->createDnsRecord('dns-data', 'data.example.com', 'A', '10.0.0.1');

        $result = $this->exportService->exportDns('csv');
        $lines = explode("\n", $result['data']);

        $this->assertCount(2, $lines); // header + 1 data row
        $this->assertStringContainsString('dns-data', $lines[1]);
        $this->assertStringContainsString('data.example.com', $lines[1]);
        $this->assertStringContainsString('A', $lines[1]);
        $this->assertStringContainsString('10.0.0.1', $lines[1]);
    }

    /**
     * Test exportDns handles DNS record with server_id
     */
    public function test_export_dns_handles_dns_record_with_server_id()
    {
        DNS::create([
            'id' => 'dns-server',
            'hostname' => 'server.example.com',
            'dns_type' => 'A',
            'address' => '192.168.1.100',
            'server_id' => 'srv001',
            'domain_id' => null,
        ]);

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);
        $dns = $data[0];

        $this->assertEquals('srv001', $dns['server_id']);
        $this->assertNull($dns['domain_id']);
    }

    /**
     * Test exportDns handles DNS record with domain_id
     */
    public function test_export_dns_handles_dns_record_with_domain_id()
    {
        DNS::create([
            'id' => 'dns-domain',
            'hostname' => 'domain.example.com',
            'dns_type' => 'A',
            'address' => '192.168.1.200',
            'server_id' => null,
            'domain_id' => 'dom001',
        ]);

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);
        $dns = $data[0];

        $this->assertNull($dns['server_id']);
        $this->assertEquals('dom001', $dns['domain_id']);
    }

    /**
     * Test exportDns handles special characters in TXT records
     * Validates: Requirement 8.4
     */
    public function test_export_dns_handles_special_characters_in_txt_records()
    {
        $txtValue = 'v=DKIM1; k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC';
        $this->createDnsRecord('dns-special', 'dkim.example.com', 'TXT', $txtValue);

        $result = $this->exportService->exportDns('json');
        $data = json_decode($result['data'], true);

        $this->assertEquals($txtValue, $data[0]['address']);
    }
}
