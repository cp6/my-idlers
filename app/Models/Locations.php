<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'locations';

    protected $keyType = 'string';

    public static function allLocations(): array
    {
        return Cache::remember("locations", now()->addMonth(1), function () {
            return DB::table('locations')->get()->toArray();
        });
    }
}
