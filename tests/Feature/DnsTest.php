<?php

namespace Tests\Feature;

use App\Models\DNS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DnsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guests_cannot_access_dns_index()
    {
        $response = $this->get(route('dns.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_dns_index()
    {
        $response = $this->actingAs($this->user)->get(route('dns.index'));
        $response->assertStatus(200);
        $response->assertViewIs('dns.index');
    }

    public function test_authenticated_user_can_view_create_dns_form()
    {
        $response = $this->actingAs($this->user)->get(route('dns.create'));
        $response->assertStatus(200);
        $response->assertViewIs('dns.create');
    }

    public function test_authenticated_user_can_create_dns_record()
    {
        $response = $this->actingAs($this->user)->post(route('dns.store'), [
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => 'A',
            'server_id' => 'null',
            'shared_id' => 'null',
            'reseller_id' => 'null',
            'domain_id' => 'null'
        ]);

        $response->assertRedirect(route('dns.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('d_n_s', [
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => 'A'
        ]);
    }

    public function test_dns_hostname_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('dns.store'), [
            'hostname' => '',
            'address' => '192.168.1.1',
            'dns_type' => 'A'
        ]);

        $response->assertSessionHasErrors('hostname');
    }

    public function test_dns_address_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('dns.store'), [
            'hostname' => 'example.com',
            'address' => '',
            'dns_type' => 'A'
        ]);

        $response->assertSessionHasErrors('address');
    }

    public function test_dns_type_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('dns.store'), [
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => ''
        ]);

        $response->assertSessionHasErrors('dns_type');
    }

    public function test_authenticated_user_can_view_dns_details()
    {
        $dns = DNS::create([
            'id' => 'testdns1',
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => 'A'
        ]);

        $response = $this->actingAs($this->user)->get(route('dns.show', $dns));
        $response->assertStatus(200);
        $response->assertViewIs('dns.show');
    }

    public function test_authenticated_user_can_update_dns_record()
    {
        $dns = DNS::create([
            'id' => 'testdns2',
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => 'A'
        ]);

        $response = $this->actingAs($this->user)->put(route('dns.update', $dns), [
            'hostname' => 'updated.example.com',
            'address' => '192.168.1.2',
            'dns_type' => 'AAAA',
            'server_id' => 'null',
            'shared_id' => 'null',
            'reseller_id' => 'null',
            'domain_id' => 'null'
        ]);

        $response->assertRedirect(route('dns.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('d_n_s', [
            'hostname' => 'updated.example.com',
            'address' => '192.168.1.2',
            'dns_type' => 'AAAA'
        ]);
    }

    public function test_authenticated_user_can_delete_dns_record()
    {
        $dns = DNS::create([
            'id' => 'testdns3',
            'hostname' => 'example.com',
            'address' => '192.168.1.1',
            'dns_type' => 'A'
        ]);

        $response = $this->actingAs($this->user)->delete(route('dns.destroy', $dns));

        $response->assertRedirect(route('dns.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('d_n_s', ['hostname' => 'example.com']);
    }
}
