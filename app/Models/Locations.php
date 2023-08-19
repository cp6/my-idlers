<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'locations';

    protected $keyType = 'string';

    public static function allLocations(): array
    {
        return Cache::remember("locations", now()->addMonth(1), function () {
            return self::orderBy('name')->get()->toArray();
        });
    }
}
