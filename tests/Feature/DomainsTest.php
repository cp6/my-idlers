<?php

namespace Tests\Feature;

use App\Models\Domains;
use App\Models\Pricing;
use App\Models\Providers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DomainsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Providers $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->provider = Providers::create(['name' => 'Test Provider']);
    }

    protected function createDomainWithPricing(string $id, string $domain, string $extension): Domains
    {
        // Create pricing first (foreign key constraint)
        Pricing::create([
            'service_id' => $id,
            'service_type' => 4, // Domain type
            'currency' => 'USD',
            'price' => 10.00,
            'term' => 4,
            'as_usd' => 10.00,
            'usd_per_month' => 0.83,
            'next_due_date' => now()->addYear()->format('Y-m-d')
        ]);

        return Domains::create([
            'id' => $id,
            'domain' => $domain,
            'extension' => $extension,
            'provider_id' => $this->provider->id
        ]);
    }

    public function test_guests_cannot_access_domains_index()
    {
        $response = $this->get(route('domains.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_domains_index()
    {
        $response = $this->actingAs($this->user)->get(route('domains.index'));
        $response->assertStatus(200);
        $response->assertViewIs('domains.index');
    }

    public function test_authenticated_user_can_view_create_domain_form()
    {
        $response = $this->actingAs($this->user)->get(route('domains.create'));
        $response->assertStatus(200);
        $response->assertViewIs('domains.create');
    }

    public function test_authenticated_user_can_create_domain()
    {
        $response = $this->actingAs($this->user)->post(route('domains.store'), [
            'domain' => 'example',
            'extension' => 'com',
            'provider_id' => $this->provider->id,
            'currency' => 'USD',
            'price' => 10.00,
            'payment_term' => 4,
            'next_due_date' => now()->addYear()->format('Y-m-d')
        ]);

        $response->assertRedirect(route('domains.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('domains', [
            'domain' => 'example',
            'extension' => 'com'
        ]);
    }

    public function test_domain_name_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('domains.store'), [
            'domain' => '',
            'extension' => 'com',
            'provider_id' => $this->provider->id,
            'currency' => 'USD',
            'price' => 10.00,
            'payment_term' => 4,
            'next_due_date' => now()->addYear()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('domain');
    }

    public function test_domain_extension_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('domains.store'), [
            'domain' => 'example',
            'extension' => '',
            'provider_id' => $this->provider->id,
            'currency' => 'USD',
            'price' => 10.00,
            'payment_term' => 4,
            'next_due_date' => now()->addYear()->format('Y-m-d')
        ]);

        $response->assertSessionHasErrors('extension');
    }

    public function test_domain_next_due_date_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('domains.store'), [
            'domain' => 'example',
            'extension' => 'com',
            'provider_id' => $this->provider->id,
            'currency' => 'USD',
            'price' => 10.00,
            'payment_term' => 4,
            'next_due_date' => ''
        ]);

        $response->assertSessionHasErrors('next_due_date');
    }

    public function test_authenticated_user_can_view_domain_details()
    {
        $domain = $this->createDomainWithPricing('testdom1', 'example', 'com');

        $response = $this->actingAs($this->user)->get(route('domains.show', $domain));
        $response->assertStatus(200);
        $response->assertViewIs('domains.show');
    }

    public function test_authenticated_user_can_delete_domain()
    {
        $domain = $this->createDomainWithPricing('testdom2', 'example', 'com');

        $response = $this->actingAs($this->user)->delete(route('domains.destroy', $domain));

        $response->assertRedirect(route('domains.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('domains', ['id' => 'testdom2']);
    }
}
