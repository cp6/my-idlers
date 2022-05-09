<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Providers extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'providers';

    public static function allProviders(): array
    {
        return Cache::remember("providers", now()->addMonth(1), function () {
            return DB::table('providers')->get()->toArray();
        });
    }
}
