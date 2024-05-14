<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Settings extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = ['id', 'show_versions_footer', 'show_servers_public', 'show_server_value_ip', 'show_server_value_hostname', 'show_server_value_provider', 'show_server_value_location', 'show_server_value_price', 'show_server_value_yabs', 'save_yabs_as_txt', 'default_currency', 'default_server_os', 'due_soon_amount', 'recently_added_amount', 'dark_mode', 'dashboard_currency', 'sort_on', 'favicon'];

    public static function getSettings(): Settings
    {
        return Cache::remember('settings', now()->addWeek(1), function () {
            $settings = self::where('id', 1)->first();
            if (is_null($settings)){
                $settings = Settings::create();
            }
            return $settings;
        });
    }

    public static function setSettingsToSession($settings): void
    {
        Session::put('dark_mode', $settings->dark_mode ?? 0);
        Session::put('timer_version_footer', $settings->show_versions_footer ?? 1);
        Session::put('show_servers_public', $settings->show_servers_public ?? 0);
        Session::put('show_server_value_ip', $settings->show_server_value_ip ?? 0);
        Session::put('show_server_value_hostname', $settings->show_server_value_hostname ?? 0);
        Session::put('show_server_value_price', $settings->show_server_value_price ?? 0);
        Session::put('show_server_value_yabs', $settings->show_server_value_yabs ?? 0);
        Session::put('show_server_value_provider', $settings->show_server_value_provider ?? 0);
        Session::put('show_server_value_location', $settings->show_server_value_location ?? 0);
        Session::put('save_yabs_as_txt', $settings->save_yabs_as_txt ?? 0);
        Session::put('default_currency', $settings->default_currency ?? 'USD');
        Session::put('default_server_os', $settings->default_server_os ?? 1);
        Session::put('due_soon_amount', $settings->due_soon_amount ?? 6);
        Session::put('recently_added_amount', $settings->recently_added_amount ?? 6);
        Session::put('dashboard_currency', $settings->dashboard_currency ?? 'USD');
        Session::put('sort_on', $settings->sort_on ?? 1);
        Session::put('favicon', $settings->favicon ?? 'favicon.ico');
        Session::save();
    }

    public static function orderByProcess(int $value): array
    {
        if ($value === 1) {//created_at ASC
            return ['created_at', 'asc'];
        } elseif ($value === 2) {//created_at DESC
            return ['created_at', 'desc'];
        } elseif ($value === 3) {//next_due_date ASC
            return ['next_due_date', 'asc'];
        } elseif ($value === 4) {//next_due_date DESC
            return ['next_due_date', 'desc'];
        } elseif ($value === 5) {//as_usd ASC
            return ['as_usd', 'asc'];
        } elseif ($value === 6) {//as_usd DESC
            return ['as_usd', 'desc'];
        } elseif ($value === 7) {//owned_since ASC
            return ['owned_since', 'asc'];
        } elseif ($value === 8) {//owned_since DESC
            return ['owned_since', 'desc'];
        } elseif ($value === 9) {//updated_at ASC
            return ['updated_at', 'asc'];
        } elseif ($value === 10) {//updated_at DESC
            return ['updated_at', 'desc'];
        }
        return ['created_at', 'desc'];
    }

}
