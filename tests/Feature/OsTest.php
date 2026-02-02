<?php

namespace Tests\Feature;

use App\Models\OS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guests_cannot_access_os_index()
    {
        $response = $this->get(route('os.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_os_index()
    {
        $response = $this->actingAs($this->user)->get(route('os.index'));
        $response->assertStatus(200);
        $response->assertViewIs('os.index');
    }

    public function test_authenticated_user_can_view_create_os_form()
    {
        $response = $this->actingAs($this->user)->get(route('os.create'));
        $response->assertStatus(200);
        $response->assertViewIs('os.create');
    }

    public function test_authenticated_user_can_create_os()
    {
        $response = $this->actingAs($this->user)->post(route('os.store'), [
            'os_name' => 'Ubuntu 22.04'
        ]);

        $response->assertRedirect(route('os.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('os', ['name' => 'Ubuntu 22.04']);
    }

    public function test_os_name_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('os.store'), [
            'os_name' => ''
        ]);

        $response->assertSessionHasErrors('os_name');
    }

    public function test_os_name_must_be_at_least_2_characters()
    {
        $response = $this->actingAs($this->user)->post(route('os.store'), [
            'os_name' => 'A'
        ]);

        $response->assertSessionHasErrors('os_name');
    }

    public function test_authenticated_user_can_delete_os()
    {
        $os = OS::create(['name' => 'Test OS']);

        // The route parameter is 'o' not 'os' based on the controller
        $response = $this->actingAs($this->user)->delete(route('os.destroy', ['o' => $os->id]));

        $response->assertRedirect(route('os.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('os', ['name' => 'Test OS']);
    }
}
