<?php

namespace Tests\Feature;

use App\Models\IPs;
use App\Models\Locations;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Server;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IpsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Server $server;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        
        $provider = Providers::create(['name' => 'Test Provider']);
        $location = Locations::create(['name' => 'Test Location']);
        $os = OS::create(['name' => 'Ubuntu 22.04']);
        Settings::create(['id' => 1]);

        // Create pricing first
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

    public function test_guests_cannot_access_ips_index()
    {
        $response = $this->get(route('IPs.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_ips_index()
    {
        $response = $this->actingAs($this->user)->get(route('IPs.index'));
        $response->assertStatus(200);
        $response->assertViewIs('ips.index');
    }

    public function test_authenticated_user_can_view_create_ip_form()
    {
        $response = $this->actingAs($this->user)->get(route('IPs.create'));
        $response->assertStatus(200);
        $response->assertViewIs('ips.create');
    }

    public function test_authenticated_user_can_create_ip()
    {
        // Mock the HTTP call to ipwhois.app
        \Illuminate\Support\Facades\Http::fake([
            'ipwhois.app/*' => \Illuminate\Support\Facades\Http::response([
                'continent' => 'North America',
                'country' => 'United States',
                'region' => 'California',
                'city' => 'Los Angeles',
                'org' => 'Test Org',
                'isp' => 'Test ISP',
                'asn' => 'AS12345',
                'timezone_gmt' => '-08:00'
            ], 200)
        ]);

        $response = $this->actingAs($this->user)->post(route('IPs.store'), [
            'address' => '192.168.1.100',
            'ip_type' => 'ipv4',
            'service_id' => $this->server->id
        ]);

        $response->assertRedirect(route('IPs.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('ips', ['address' => '192.168.1.100']);
    }

    public function test_ip_address_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('IPs.store'), [
            'address' => '',
            'ip_type' => 'ipv4',
            'service_id' => $this->server->id
        ]);

        $response->assertSessionHasErrors('address');
    }

    public function test_ip_address_must_be_valid()
    {
        $response = $this->actingAs($this->user)->post(route('IPs.store'), [
            'address' => 'invalid-ip',
            'ip_type' => 'ipv4',
            'service_id' => $this->server->id
        ]);

        $response->assertSessionHasErrors('address');
    }

    public function test_ip_type_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('IPs.store'), [
            'address' => '192.168.1.100',
            'ip_type' => '',
            'service_id' => $this->server->id
        ]);

        $response->assertSessionHasErrors('ip_type');
    }

    public function test_service_id_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('IPs.store'), [
            'address' => '192.168.1.100',
            'ip_type' => 'ipv4',
            'service_id' => ''
        ]);

        $response->assertSessionHasErrors('service_id');
    }

    public function test_authenticated_user_can_delete_ip()
    {
        $ip = IPs::create([
            'id' => 'testip01',
            'service_id' => $this->server->id,
            'address' => '192.168.1.100',
            'is_ipv4' => 1,
            'active' => 1
        ]);

        $response = $this->actingAs($this->user)->delete(route('IPs.destroy', $ip));

        $response->assertRedirect(route('IPs.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('ips', ['id' => 'testip01']);
    }
}
