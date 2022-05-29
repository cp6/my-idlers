<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['id', 'show_versions_footer', 'show_servers_public'];

    public static function getSettings()
    {
        return Cache::remember('settings', now()->addMinute(1), function () {
            return DB::table('settings')
                ->where('id', '=', 1)
                ->get();
        });
    }

    public static function setSettingsToSession($settings): void
    {
        Session::put('dark_mode', $settings[0]->dark_mode ?? 0);
        Session::put('timer_version_footer', $settings[0]->show_versions_footer ?? 1);
        Session::put('show_servers_public', $settings[0]->show_servers_public ?? 0);
        Session::put('show_server_value_ip', $settings[0]->show_server_value_ip ?? 0);
        Session::put('show_server_value_hostname', $settings[0]->show_server_value_hostname ?? 0);
        Session::put('show_server_value_price', $settings[0]->show_server_value_price ?? 0);
        Session::put('show_server_value_yabs', $settings[0]->show_server_value_yabs ?? 0);
        Session::put('show_server_value_provider', $settings[0]->show_server_value_provider ?? 0);
        Session::put('show_server_value_location', $settings[0]->show_server_value_location ?? 0);
        Session::put('default_currency', $settings[0]->default_currency ?? 'USD');
        Session::put('default_server_os', $settings[0]->default_server_os ?? 1);
        Session::put('due_soon_amount', $settings[0]->due_soon_amount ?? 6);
        Session::put('recently_added_amount', $settings[0]->recently_added_amount ?? 6);
        Session::put('dashboard_currency', $settings[0]->dashboard_currency ?? 'USD');
        Session::save();
    }


}
