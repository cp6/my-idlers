<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelsAssigned extends Model
{
    use HasFactory;

    public $incrementing = false;

    public $table = 'labels_assigned';

    protected $fillable = ['label_id', 'service_id'];

    public function label()
    {
        return $this->hasOne(Labels::class, 'id', 'label_id');
    }

}
