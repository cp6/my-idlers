<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['id', 'show_versions_footer', 'show_servers_public'];

    public static function getSettings()
    {
        return DB::table('settings')
            ->where('id', '=', 1)
            ->get();
    }
}
