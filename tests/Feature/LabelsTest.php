<?php

namespace Tests\Feature;

use App\Models\Labels;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guests_cannot_access_labels_index()
    {
        $response = $this->get(route('labels.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_labels_index()
    {
        $response = $this->actingAs($this->user)->get(route('labels.index'));
        $response->assertStatus(200);
        $response->assertViewIs('labels.index');
    }

    public function test_authenticated_user_can_view_create_label_form()
    {
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertStatus(200);
        $response->assertViewIs('labels.create');
    }

    public function test_authenticated_user_can_create_label()
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'label' => 'Production'
        ]);

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('labels', ['label' => 'Production']);
    }

    public function test_label_is_required()
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'label' => ''
        ]);

        $response->assertSessionHasErrors('label');
    }

    public function test_label_must_be_at_least_2_characters()
    {
        $response = $this->actingAs($this->user)->post(route('labels.store'), [
            'label' => 'A'
        ]);

        $response->assertSessionHasErrors('label');
    }

    public function test_authenticated_user_can_view_label_details()
    {
        $label = Labels::create(['id' => 'testlbl1', 'label' => 'Test Label']);

        $response = $this->actingAs($this->user)->get(route('labels.show', $label));
        $response->assertStatus(200);
        $response->assertViewIs('labels.show');
    }

    public function test_authenticated_user_can_delete_label()
    {
        $label = Labels::create(['id' => 'testlbl2', 'label' => 'Test Label']);

        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('labels', ['label' => 'Test Label']);
    }
}
