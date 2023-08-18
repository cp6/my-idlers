<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Labels extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'labels';

    protected $keyType = 'string';

    protected $fillable = ['id', 'label', 'server_id', 'server_id_2', 'domain_id', 'domain_id_2', 'shared_id', 'shared_id_2'];

    public static function deleteLabelsAssignedTo($service_id)
    {
        DB::table('labels_assigned')->where('service_id', $service_id)->delete();
    }

    public static function deleteLabelAssignedAs($label_id)
    {
        DB::table('labels_assigned')->where('label_id', $label_id)->delete();
    }

    public static function insertLabelsAssigned(array $labels_array, string $service_id)
    {
        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::table('labels_assigned')->insert(['label_id' => $labels_array[($i - 1)], 'service_id' => $service_id]);
            }
        }
    }

    public static function labelsCount()
    {
        return Cache::remember('labels_count', now()->addMonth(1), function () {
            return Labels::count();
        });
    }

    public function assigned()
    {
        return $this->hasMany(LabelsAssigned::class, 'label_id', 'id');
    }

}
