<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelsAssigned extends Model
{
    use HasFactory;

    public $incrementing = false;

    public $timestamps = false;

    public $table = 'labels_assigned';

    protected $fillable = ['label_id', 'service_id'];

    protected $keyType = 'string';

    public function label(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Labels::class, 'id', 'label_id');
    }

}
