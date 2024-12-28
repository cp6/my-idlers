<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OS extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $keyType = 'string';

    protected $table = 'os';

    public static function allOS()
    {
        return Cache::remember("operating_systems", now()->addMonth(1), function () {
            return self::orderBy('name')->get();
        });
    }
}
