<?php

namespace Tests\Feature;

use App\Models\Providers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProvidersTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guests_cannot_access_providers_index()
    {
        $response = $this->get(route('providers.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_providers_index()
    {
        $response = $this->actingAs($this->user)->get(route('providers.index'));
        $response->assertStatus(200);
        $response->assertViewIs('providers.index');
    }

    public function test_authenticated_user_can_view_create_provider_form()
    {
        $response = $this->actingAs($this->user)->get(route('providers.create'));
        $response->assertStatus(200);
        $response->assertViewIs('providers.create');
    }

    public function test_authenticated_user_can_create_provider()
    {
        $response = $this->actingAs($this->user)->post(route('providers.store'), [
            'provider_name' => 'Test Provider'
        ]);

        $response->assertRedirect(route('providers.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('providers', ['name' => 'Test Provider']);
    }

    public function test_provider_name_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('providers.store'), [
            'provider_name' => ''
        ]);

        $response->assertSessionHasErrors('provider_name');
    }

    public function test_provider_name_must_be_at_least_2_characters()
    {
        $response = $this->actingAs($this->user)->post(route('providers.store'), [
            'provider_name' => 'A'
        ]);

        $response->assertSessionHasErrors('provider_name');
    }

    public function test_authenticated_user_can_view_provider_details()
    {
        $provider = Providers::create(['name' => 'Test Provider']);

        $response = $this->actingAs($this->user)->get(route('providers.show', $provider));
        $response->assertStatus(200);
        $response->assertViewIs('providers.show');
    }

    public function test_authenticated_user_can_delete_provider()
    {
        $provider = Providers::create(['name' => 'Test Provider']);

        $response = $this->actingAs($this->user)->delete(route('providers.destroy', $provider));

        $response->assertRedirect(route('providers.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('providers', ['name' => 'Test Provider']);
    }
}
