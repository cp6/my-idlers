<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Misc extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'misc_services';

    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'owned_since'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $array = Settings::orderByProcess(Session::get('sort_on'));
            if (!in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $builder->orderBy($array[0], $array[1]);
            }
        });
    }

    public static function allMisc()
    {//All misc and relationships (no using joins)
        return Cache::remember("all_misc", now()->addMonth(1), function () {
            $query = Misc::with(['price']);
            if (in_array(Session::get('sort_on'), [3, 4, 5, 6], true)) {
                $options = Settings::orderByProcess(Session::get('sort_on'));
                $query->orderBy(Pricing::select("pricings.$options[0]")->whereColumn("pricings.service_id", "misc_services.id"), $options[1]);
            }
            return $query->get();
        });
    }

    public static function misc(string $misc_id)
    {//Single misc and relationships (no using joins)
        return Cache::remember("misc.$misc_id", now()->addMonth(1), function () use ($misc_id) {
            return Misc::where('id', $misc_id)
                ->with(['price'])->first();
        });
    }

    public function price()
    {
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

}
