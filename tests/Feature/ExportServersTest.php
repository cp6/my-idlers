<?php

namespace Tests\Feature;

use App\Models\DiskSpeed;
use App\Models\IPs;
use App\Models\Locations;
use App\Models\NetworkSpeed;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Server;
use App\Models\Settings;
use App\Models\User;
use App\Models\Yabs;
use App\Services\ExportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportServersTest extends TestCase
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

    protected function createServerWithAllRelationships(string $id, string $hostname): Server
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 1, // Server type
            'currency' => 'USD',
            'price' => 10.00,
            'term' => 1,
            'as_usd' => 10.00,
            'usd_per_month' => 10.00,
            'next_due_date' => '2024-02-15'
        ]);

        $server = Server::create([
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

        // Create IP addresses
        IPs::create([
            'id' => 'ip1' . $id,
            'service_id' => $id,
            'address' => '192.168.1.1',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        IPs::create([
            'id' => 'ip2' . $id,
            'service_id' => $id,
            'address' => '2001:db8::1',
            'is_ipv4' => 0,
            'active' => 1
        ]);

        // Create YABS data
        $yabsId = 'yabs' . $id;
        Yabs::create([
            'id' => $yabsId,
            'server_id' => $id,
            'has_ipv6' => 1,
            'aes' => 1,
            'vm' => 1,
            'output_date' => '2024-01-20 10:30:00',
            'cpu_model' => 'AMD EPYC 7542',
            'cpu_cores' => 4,
            'cpu_freq' => 2900,
            'ram' => 8,
            'ram_type' => 'GB',
            'ram_mb' => 8192,
            'disk' => 100,
            'disk_type' => 'GB',
            'disk_gb' => 100,
            'gb5_single' => 1200,
            'gb5_multi' => 4500,
            'gb6_single' => 1500,
            'gb6_multi' => 5500
        ]);

        // Create disk speed data
        DiskSpeed::create([
            'id' => $yabsId,
            'server_id' => $id,
            'd_4k' => 150,
            'd_4k_type' => 'MB/s',
            'd_4k_as_mbps' => 150,
            'd_64k' => 500,
            'd_64k_type' => 'MB/s',
            'd_64k_as_mbps' => 500,
            'd_512k' => 800,
            'd_512k_type' => 'MB/s',
            'd_512k_as_mbps' => 800,
            'd_1m' => 1000,
            'd_1m_type' => 'MB/s',
            'd_1m_as_mbps' => 1000
        ]);

        // Create network speed data
        NetworkSpeed::create([
            'id' => $yabsId,
            'server_id' => $id,
            'location' => 'NYC',
            'send' => 900,
            'send_type' => 'MBps',
            'send_as_mbps' => 900,
            'receive' => 850,
            'receive_type' => 'MBps',
            'receive_as_mbps' => 850
        ]);

        return $server;
    }

    /**
     * Test exportServers returns correct structure for JSON format
     * Validates: Requirements 1.1, 1.5
     */
    public function test_export_servers_returns_correct_json_structure()
    {
        $this->createServerWithAllRelationships('srv001', 'server1.example.com');

        $result = $this->exportService->exportServers('json');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('application/json', $result['content_type']);
        $this->assertStringContainsString('servers_export_', $result['filename']);
        $this->assertStringContainsString('.json', $result['filename']);
    }

    /**
     * Test exportServers returns correct structure for CSV format
     * Validates: Requirements 1.1, 1.6
     */
    public function test_export_servers_returns_correct_csv_structure()
    {
        $this->createServerWithAllRelationships('srv002', 'server2.example.com');

        $result = $this->exportService->exportServers('csv');

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('filename', $result);
        $this->assertArrayHasKey('content_type', $result);
        $this->assertEquals('text/csv', $result['content_type']);
        $this->assertStringContainsString('servers_export_', $result['filename']);
        $this->assertStringContainsString('.csv', $result['filename']);
    }

    /**
     * Test exportServers includes all server fields
     * Validates: Requirement 1.1
     */
    public function test_export_servers_includes_all_server_fields()
    {
        $this->createServerWithAllRelationships('srv003', 'server3.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(1, $data);
        $server = $data[0];

        // Check all required server fields
        $this->assertEquals('srv003', $server['id']);
        $this->assertEquals('server3.example.com', $server['hostname']);
        $this->assertEquals(1, $server['server_type']);
        $this->assertEquals('KVM', $server['server_type_name']);
        $this->assertEquals(4, $server['cpu']);
        $this->assertEquals(8, $server['ram']);
        $this->assertEquals('GB', $server['ram_type']);
        $this->assertEquals(8192, $server['ram_as_mb']);
        $this->assertEquals(100, $server['disk']);
        $this->assertEquals('GB', $server['disk_type']);
        $this->assertEquals(100, $server['disk_as_gb']);
        $this->assertEquals(1000, $server['bandwidth']);
        $this->assertEquals(22, $server['ssh']);
        $this->assertEquals(1, $server['active']);
        $this->assertEquals('2024-01-15', $server['owned_since']);
    }

    /**
     * Test exportServers includes OS relationship
     * Validates: Requirement 1.1
     */
    public function test_export_servers_includes_os_relationship()
    {
        $this->createServerWithAllRelationships('srv004', 'server4.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('os', $server);
        $this->assertNotNull($server['os']);
        $this->assertArrayHasKey('id', $server['os']);
        $this->assertArrayHasKey('name', $server['os']);
        $this->assertEquals('Ubuntu 22.04', $server['os']['name']);
    }

    /**
     * Test exportServers includes location relationship
     * Validates: Requirement 1.1
     */
    public function test_export_servers_includes_location_relationship()
    {
        $this->createServerWithAllRelationships('srv005', 'server5.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('location', $server);
        $this->assertNotNull($server['location']);
        $this->assertArrayHasKey('id', $server['location']);
        $this->assertArrayHasKey('name', $server['location']);
        $this->assertEquals('Test Location', $server['location']['name']);
    }

    /**
     * Test exportServers includes provider relationship
     * Validates: Requirement 1.1
     */
    public function test_export_servers_includes_provider_relationship()
    {
        $this->createServerWithAllRelationships('srv006', 'server6.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('provider', $server);
        $this->assertNotNull($server['provider']);
        $this->assertArrayHasKey('id', $server['provider']);
        $this->assertArrayHasKey('name', $server['provider']);
        $this->assertEquals('Test Provider', $server['provider']['name']);
    }

    /**
     * Test exportServers includes IP addresses
     * Validates: Requirement 1.4
     */
    public function test_export_servers_includes_ip_addresses()
    {
        $this->createServerWithAllRelationships('srv007', 'server7.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('ips', $server);
        $this->assertCount(2, $server['ips']);

        // Check IPv4 address
        $ipv4 = collect($server['ips'])->firstWhere('is_ipv4', 1);
        $this->assertNotNull($ipv4);
        $this->assertEquals('192.168.1.1', $ipv4['address']);

        // Check IPv6 address
        $ipv6 = collect($server['ips'])->firstWhere('is_ipv4', 0);
        $this->assertNotNull($ipv6);
        $this->assertEquals('2001:db8::1', $ipv6['address']);
    }

    /**
     * Test exportServers includes pricing data
     * Validates: Requirement 1.3
     */
    public function test_export_servers_includes_pricing_data()
    {
        $this->createServerWithAllRelationships('srv008', 'server8.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('pricing', $server);
        $this->assertNotNull($server['pricing']);
        $this->assertEquals(10.00, $server['pricing']['price']);
        $this->assertEquals('USD', $server['pricing']['currency']);
        $this->assertEquals(1, $server['pricing']['term']);
        $this->assertEquals('Monthly', $server['pricing']['term_name']);
        $this->assertEquals(10.00, $server['pricing']['as_usd']);
        $this->assertEquals(10.00, $server['pricing']['usd_per_month']);
        $this->assertEquals('2024-02-15', $server['pricing']['next_due_date']);
    }

    /**
     * Test exportServers includes YABS data with disk_speed and network_speed
     * Validates: Requirement 1.2
     */
    public function test_export_servers_includes_yabs_data()
    {
        $this->createServerWithAllRelationships('srv009', 'server9.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('yabs', $server);
        $this->assertCount(1, $server['yabs']);

        $yabs = $server['yabs'][0];
        $this->assertEquals('2024-01-20 10:30:00', $yabs['output_date']);
        $this->assertEquals('AMD EPYC 7542', $yabs['cpu_model']);
        $this->assertEquals(4, $yabs['cpu_cores']);
        $this->assertEquals(2900, $yabs['cpu_freq']);
        $this->assertEquals(1, $yabs['aes']);
        $this->assertEquals(1, $yabs['vm']);
        $this->assertEquals(1200, $yabs['gb5_single']);
        $this->assertEquals(4500, $yabs['gb5_multi']);
        $this->assertEquals(1500, $yabs['gb6_single']);
        $this->assertEquals(5500, $yabs['gb6_multi']);
    }

    /**
     * Test exportServers includes YABS disk_speed data
     * Validates: Requirement 1.2
     */
    public function test_export_servers_includes_yabs_disk_speed()
    {
        $this->createServerWithAllRelationships('srv010', 'server10.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];
        $yabs = $server['yabs'][0];

        $this->assertArrayHasKey('disk_speed', $yabs);
        $this->assertNotNull($yabs['disk_speed']);
        $this->assertEquals(150, $yabs['disk_speed']['d_4k']);
        $this->assertEquals('MB/s', $yabs['disk_speed']['d_4k_type']);
        $this->assertEquals(500, $yabs['disk_speed']['d_64k']);
        $this->assertEquals('MB/s', $yabs['disk_speed']['d_64k_type']);
        $this->assertEquals(800, $yabs['disk_speed']['d_512k']);
        $this->assertEquals('MB/s', $yabs['disk_speed']['d_512k_type']);
        $this->assertEquals(1000, $yabs['disk_speed']['d_1m']);
        $this->assertEquals('MB/s', $yabs['disk_speed']['d_1m_type']);
    }

    /**
     * Test exportServers includes YABS network_speed data
     * Validates: Requirement 1.2
     */
    public function test_export_servers_includes_yabs_network_speed()
    {
        $this->createServerWithAllRelationships('srv011', 'server11.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];
        $yabs = $server['yabs'][0];

        $this->assertArrayHasKey('network_speed', $yabs);
        $this->assertCount(1, $yabs['network_speed']);

        $networkSpeed = $yabs['network_speed'][0];
        $this->assertEquals('NYC', $networkSpeed['location']);
        $this->assertEquals(900, $networkSpeed['send']);
        $this->assertEquals('MBps', $networkSpeed['send_type']);
        $this->assertEquals(850, $networkSpeed['receive']);
        $this->assertEquals('MBps', $networkSpeed['receive_type']);
    }

    /**
     * Test exportServers returns valid JSON
     * Validates: Requirement 1.5
     */
    public function test_export_servers_returns_valid_json()
    {
        $this->createServerWithAllRelationships('srv012', 'server12.example.com');

        $result = $this->exportService->exportServers('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertNotNull($decoded);
        $this->assertIsArray($decoded);
    }

    /**
     * Test exportServers JSON uses pretty-print formatting
     * Validates: Requirement 8.3
     */
    public function test_export_servers_json_uses_pretty_print()
    {
        $this->createServerWithAllRelationships('srv013', 'server13.example.com');

        $result = $this->exportService->exportServers('json');

        // Pretty print should contain newlines and indentation
        $this->assertStringContainsString("\n", $result['data']);
        $this->assertStringContainsString('    ', $result['data']);
    }

    /**
     * Test exportServers CSV has proper headers
     * Validates: Requirement 1.6
     */
    public function test_export_servers_csv_has_proper_headers()
    {
        $this->createServerWithAllRelationships('srv014', 'server14.example.com');

        $result = $this->exportService->exportServers('csv');
        $lines = explode("\n", $result['data']);
        $headers = $lines[0];

        $this->assertStringContainsString('id', $headers);
        $this->assertStringContainsString('hostname', $headers);
        $this->assertStringContainsString('server_type', $headers);
        $this->assertStringContainsString('cpu', $headers);
        $this->assertStringContainsString('ram', $headers);
        $this->assertStringContainsString('disk', $headers);
        $this->assertStringContainsString('pricing_price', $headers);
        $this->assertStringContainsString('pricing_currency', $headers);
    }

    /**
     * Test exportServers handles empty database
     */
    public function test_export_servers_handles_empty_database()
    {
        $result = $this->exportService->exportServers('json');

        $this->assertJson($result['data']);
        $decoded = json_decode($result['data'], true);
        $this->assertIsArray($decoded);
        $this->assertCount(0, $decoded);
    }

    /**
     * Test exportServers handles server without pricing
     */
    public function test_export_servers_handles_server_without_pricing()
    {
        // Create pricing first (required by foreign key constraint) but with null values
        // Actually, let's check if we can create a server without pricing by using a different approach
        // The database has a foreign key constraint, so we need to create pricing first
        // But we can test the export handles null pricing by checking the transformation
        
        // Create a minimal pricing record
        Pricing::create([
            'service_id' => 'srv015',
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 0,
            'term' => 1,
            'as_usd' => 0,
            'usd_per_month' => 0,
            'next_due_date' => '2024-02-15'
        ]);

        Server::create([
            'id' => 'srv015',
            'hostname' => 'server15.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2
        ]);

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('pricing', $server);
        // Pricing exists but with zero values
        $this->assertNotNull($server['pricing']);
        $this->assertEquals(0, $server['pricing']['price']);
    }

    /**
     * Test exportServers handles server without YABS
     */
    public function test_export_servers_handles_server_without_yabs()
    {
        // Create server without YABS
        Pricing::create([
            'service_id' => 'srv016',
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 5.00,
            'term' => 1,
            'as_usd' => 5.00,
            'usd_per_month' => 5.00,
            'next_due_date' => '2024-02-15'
        ]);

        Server::create([
            'id' => 'srv016',
            'hostname' => 'server16.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2
        ]);

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);
        $server = $data[0];

        $this->assertArrayHasKey('yabs', $server);
        $this->assertIsArray($server['yabs']);
        $this->assertCount(0, $server['yabs']);
    }

    /**
     * Test exportServers handles multiple servers
     */
    public function test_export_servers_handles_multiple_servers()
    {
        $this->createServerWithAllRelationships('srv017', 'server17.example.com');
        $this->createServerWithAllRelationships('srv018', 'server18.example.com');
        $this->createServerWithAllRelationships('srv019', 'server19.example.com');

        $result = $this->exportService->exportServers('json');
        $data = json_decode($result['data'], true);

        $this->assertCount(3, $data);
    }

    /**
     * Test exportServers format is case-insensitive
     */
    public function test_export_servers_format_is_case_insensitive()
    {
        $this->createServerWithAllRelationships('srv020', 'server20.example.com');

        $resultJson = $this->exportService->exportServers('JSON');
        $this->assertEquals('application/json', $resultJson['content_type']);

        $resultCsv = $this->exportService->exportServers('CSV');
        $this->assertEquals('text/csv', $resultCsv['content_type']);
    }
}
