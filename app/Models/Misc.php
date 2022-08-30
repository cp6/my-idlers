<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Misc extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'misc_services';

    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'owned_since'];

    public static function allMisc()
    {//All misc and relationships (no using joins)
        return Cache::remember("all_misc", now()->addMonth(1), function () {
            return Misc::with(['price'])->get();
        });
    }

    public static function misc(string $misc_id)
    {//Single misc and relationships (no using joins)
        return Cache::remember("misc.$misc_id", now()->addMonth(1), function () use ($misc_id) {
            return Misc::where('id', $misc_id)
                ->with(['price'])->get();
        });
    }

    public function price()
    {
        return $this->hasOne(Pricing::class, 'service_id', 'id');
    }

}
