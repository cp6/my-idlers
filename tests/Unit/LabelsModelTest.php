<?php

namespace Tests\Unit;

use App\Models\Labels;
use App\Models\LabelsAssigned;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelsModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_insert_labels_assigned_creates_label_assignments()
    {
        $label1 = Labels::create(['id' => 'label001', 'label' => 'Production']);
        $label2 = Labels::create(['id' => 'label002', 'label' => 'Web']);

        Labels::insertLabelsAssigned([$label1->id, $label2->id, null, null], 'service01');

        $this->assertDatabaseHas('labels_assigned', [
            'label_id' => 'label001',
            'service_id' => 'service01'
        ]);
        $this->assertDatabaseHas('labels_assigned', [
            'label_id' => 'label002',
            'service_id' => 'service01'
        ]);
    }

    public function test_delete_labels_assigned_to_removes_all_labels_for_service()
    {
        $label = Labels::create(['id' => 'label001', 'label' => 'Production']);
        Labels::insertLabelsAssigned([$label->id, null, null, null], 'service01');

        Labels::deleteLabelsAssignedTo('service01');

        $this->assertDatabaseMissing('labels_assigned', ['service_id' => 'service01']);
    }

    public function test_delete_label_assigned_as_removes_all_assignments_for_label()
    {
        $label = Labels::create(['id' => 'label001', 'label' => 'Production']);
        Labels::insertLabelsAssigned([$label->id, null, null, null], 'service01');
        Labels::insertLabelsAssigned([$label->id, null, null, null], 'service02');

        Labels::deleteLabelAssignedAs($label->id);

        $this->assertDatabaseMissing('labels_assigned', ['label_id' => 'label001']);
    }

    public function test_labels_count_returns_correct_count()
    {
        Labels::create(['id' => 'label001', 'label' => 'Production']);
        Labels::create(['id' => 'label002', 'label' => 'Web']);
        Labels::create(['id' => 'label003', 'label' => 'Database']);

        $count = Labels::labelsCount();

        $this->assertEquals(3, $count);
    }
}
