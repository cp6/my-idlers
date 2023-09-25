<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Mockery\Exception;

class Labels extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'labels';

    protected $keyType = 'string';

    protected $fillable = ['id', 'label', 'server_id', 'server_id_2', 'domain_id', 'domain_id_2', 'shared_id', 'shared_id_2'];

    public static function deleteLabelsAssignedTo($service_id): void
    {
        LabelsAssigned::where('service_id', $service_id)->delete();
    }

    public static function deleteLabelAssignedAs($label_id): void
    {
        LabelsAssigned::where('label_id', $label_id)->delete();
    }

    public static function insertLabelsAssigned(array $labels_array, string $service_id): void
    {
        for ($i = 1; $i <= 4; $i++) {
            if (!is_null($labels_array[($i - 1)])) {
                try {
                    LabelsAssigned::create([
                        'label_id' => $labels_array[($i - 1)],
                        'service_id' => $service_id
                    ]);
                } catch (Exception $exception) {

                }
            }
        }
    }

    public static function labelsCount(): int
    {
        return Cache::remember('labels_count', now()->addMonth(1), function () {
            return Labels::count();
        });
    }

    public function assigned(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(LabelsAssigned::class, 'label_id', 'id');
    }

}
