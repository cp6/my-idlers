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

    protected $fillable = ['id', 'label', 'server_id', 'server_id_2', 'domain_id', 'domain_id_2', 'shared_id', 'shared_id_2'];

    public static function deleteLabelsAssignedTo($service_id)
    {
        DB::table('labels_assigned')->where('service_id', '=', $service_id)->delete();
    }

    public static function deleteLabelAssignedAs($label_id)
    {
        DB::table('labels_assigned')->where('label_id', '=', $label_id)->delete();
    }

    public static function insertLabelsAssigned(array $labels_array, string $service_id)
    {
        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                DB::insert('INSERT INTO labels_assigned (label_id, service_id) values (?, ?)', [$labels_array[($i - 1)], $service_id]);
            }
        }
    }

    public static function labelsCount()
    {
        return Cache::remember('labels_count', now()->addMonth(1), function () {
            return DB::table('labels')->count();
        });
    }

    public static function labelsForService(string $service_id)
    {
        return Cache::remember("labels_for_service.$service_id", now()->addMinute(1), function () use ($service_id) {
            return DB::table('labels_assigned as l')
                ->join('labels', 'l.label_id', '=', 'labels.id')
                ->where('l.service_id', '=', $service_id)
                ->get(['labels.label']);
        });
    }

}
