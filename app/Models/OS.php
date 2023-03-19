<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OS extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $keyType = 'string';

    protected $table = 'os';

    public static function allOS(): array
    {
        return Cache::remember("operating_systems", now()->addMonth(1), function () {
            return DB::table('os')->orderBy('name')->get()->toArray();
        });
    }
}
