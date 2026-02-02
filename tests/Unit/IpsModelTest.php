<?php

namespace Tests\Unit;

use App\Models\IPs;
use App\Models\Locations;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpsModelTest extends TestCase
{
    use RefreshDatabase;

    protected Server $server;

    protected function setUp(): void
    {
        parent::setUp();
        
        $provider = Providers::create(['name' => 'Test Provider']);
        $location = Locations::create(['name' => 'Test Location']);
        $os = OS::create(['name' => 'Ubuntu 22.04']);

        Pricing::create([
            'service_id' => 'testsvr1',
            'service_type' => 1,
            'currency' => 'USD',
            'price' => 5.00,
            'term' => 1,
            'as_usd' => 5.00,
            'usd_per_month' => 5.00,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $this->server = Server::create([
            'id' => 'testsvr1',
            'hostname' => 'test-server.example.com',
            'server_type' => 1,
            'os_id' => $os->id,
            'provider_id' => $provider->id,
            'location_id' => $location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2
        ]);
    }

    public function test_insert_ip_creates_ipv4_record()
    {
        $ip = IPs::insertIP($this->server->id, '192.168.1.100');

        $this->assertDatabaseHas('ips', [
            'service_id' => $this->server->id,
            'address' => '192.168.1.100',
            'is_ipv4' => 1
        ]);
    }

    public function test_insert_ip_creates_ipv6_record()
    {
        $ip = IPs::insertIP($this->server->id, '2001:0db8:85a3:0000:0000:8a2e:0370:7334');

        $this->assertDatabaseHas('ips', [
            'service_id' => $this->server->id,
            'address' => '2001:0db8:85a3:0000:0000:8a2e:0370:7334',
            'is_ipv4' => 0
        ]);
    }

    public function test_delete_ips_assigned_to_removes_all_ips_for_service()
    {
        IPs::insertIP($this->server->id, '192.168.1.100');
        IPs::insertIP($this->server->id, '192.168.1.101');

        IPs::deleteIPsAssignedTo($this->server->id);

        $this->assertDatabaseMissing('ips', ['service_id' => $this->server->id]);
    }
}
