<?php

namespace Tests\Feature;

use App\Models\Locations;
use App\Models\OS;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\Server;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServersTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Providers $provider;
    protected Locations $location;
    protected OS $os;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->provider = Providers::create(['name' => 'Test Provider']);
        $this->location = Locations::create(['name' => 'Test Location']);
        $this->os = OS::create(['name' => 'Ubuntu 22.04']);
        Settings::create(['id' => 1]);
    }

    protected function createServerWithPricing(string $id, string $hostname): Server
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 1, // Server type
            'currency' => 'USD',
            'price' => 5.00,
            'term' => 1,
            'as_usd' => 5.00,
            'usd_per_month' => 5.00,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        return Server::create([
            'id' => $id,
            'hostname' => $hostname,
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2
        ]);
    }

    public function test_guests_cannot_access_servers_index()
    {
        $response = $this->get(route('servers.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_servers_index()
    {
        $response = $this->actingAs($this->user)->get(route('servers.index'));
        $response->assertStatus(200);
        $response->assertViewIs('servers.index');
    }

    public function test_authenticated_user_can_view_create_server_form()
    {
        $response = $this->actingAs($this->user)->get(route('servers.create'));
        $response->assertStatus(200);
        $response->assertViewIs('servers.create');
    }

    public function test_authenticated_user_can_create_server()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test-server.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'ram_type' => 'MB',
            'disk' => 50,
            'disk_type' => 'GB',
            'cpu' => 2,
            'bandwidth' => 1000,
            'ssh_port' => 22,
            'was_promo' => 0,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertRedirect(route('servers.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('servers', ['hostname' => 'test-server.example.com']);
    }

    public function test_server_hostname_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => '',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('hostname');
    }

    public function test_server_hostname_must_be_at_least_5_characters()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('hostname');
    }

    public function test_server_ram_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test-server.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => '',
            'disk' => 50,
            'cpu' => 2,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('ram');
    }

    public function test_server_disk_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test-server.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => '',
            'cpu' => 2,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('disk');
    }

    public function test_server_cpu_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test-server.example.com',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => '',
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('cpu');
    }

    public function test_server_ip_must_be_valid_if_provided()
    {
        $response = $this->actingAs($this->user)->post(route('servers.store'), [
            'hostname' => 'test-server.example.com',
            'ip1' => 'invalid-ip',
            'server_type' => 1,
            'os_id' => $this->os->id,
            'provider_id' => $this->provider->id,
            'location_id' => $this->location->id,
            'ram' => 2048,
            'disk' => 50,
            'cpu' => 2,
            'currency' => 'USD',
            'price' => 5.00,
            'payment_term' => 1,
            'next_due_date' => now()->addMonth()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('ip1');
    }

    public function test_authenticated_user_can_view_server_details()
    {
        $server = $this->createServerWithPricing('testsvr1', 'test-server.example.com');

        $response = $this->actingAs($this->user)->get(route('servers.show', $server));
        $response->assertStatus(200);
        $response->assertViewIs('servers.show');
    }

    public function test_authenticated_user_can_view_edit_server_form()
    {
        $server = $this->createServerWithPricing('testsvr2', 'test-server.example.com');

        $response = $this->actingAs($this->user)->get(route('servers.edit', $server));
        $response->assertStatus(200);
        $response->assertViewIs('servers.edit');
    }

    public function test_authenticated_user_can_delete_server()
    {
        $server = $this->createServerWithPricing('testsvr3', 'test-server.example.com');

        $response = $this->actingAs($this->user)->delete(route('servers.destroy', $server));

        $response->assertRedirect(route('servers.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('servers', ['id' => 'testsvr3']);
    }

    public function test_public_servers_page_returns_404_when_disabled()
    {
        Settings::where('id', 1)->update(['show_servers_public' => 0]);

        $response = $this->get(route('servers/public'));
        $response->assertStatus(404);
    }
}
