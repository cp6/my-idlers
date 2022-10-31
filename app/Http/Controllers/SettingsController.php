<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', ['setting' => Settings::where('id', 1)->first()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'dark_mode' => 'required|integer|min:0|max:1',
            'show_versions_footer' => 'required|integer|min:0|max:1',
            'show_server_value_ip' => 'required|integer|min:0|max:1',
            'show_server_value_hostname' => 'required|integer|min:0|max:1',
            'show_server_value_provider' => 'required|integer|min:0|max:1',
            'show_server_value_location' => 'required|integer|min:0|max:1',
            'show_server_value_price' => 'required|integer|min:0|max:1',
            'show_server_value_yabs' => 'required|integer|min:0|max:1',
            'save_yabs_as_txt' => 'required|integer|min:0|max:1',
            'default_currency' => 'required|string|size:3',
            'default_server_os' => 'required|integer',
            'due_soon_amount' => 'required|integer|between:0,12',
            'recently_added_amount' => 'required|integer|between:0,12',
            'currency' => 'required|string|size:3',
            'sort_on' => 'required|integer|between:1,10',
        ]);

       $update =  DB::table('settings')
            ->where('id', 1)
            ->update([
                'dark_mode' => $request->dark_mode,
                'show_versions_footer' => $request->show_versions_footer,
                'show_servers_public' => $request->show_servers_public,
                'show_server_value_ip' => $request->show_server_value_ip,
                'show_server_value_hostname' => $request->show_server_value_hostname,
                'show_server_value_provider' => $request->show_server_value_provider,
                'show_server_value_location' => $request->show_server_value_location,
                'show_server_value_price' => $request->show_server_value_price,
                'show_server_value_yabs' => $request->show_server_value_yabs,
                'save_yabs_as_txt' => $request->save_yabs_as_txt,
                'default_currency' => $request->default_currency,
                'default_server_os' => $request->default_server_os,
                'due_soon_amount' => $request->due_soon_amount,
                'recently_added_amount' => $request->recently_added_amount,
                'dashboard_currency' => $request->currency,
                'sort_on' => $request->sort_on,
            ]);

        Cache::forget('due_soon');//Main page due_soon cache
        Cache::forget('recently_added');//Main page recently_added cache
        Cache::forget('pricing_breakdown');//Main page pricing breakdown

        Cache::forget('settings');//Main page settings cache
        //Clear because they are affected by settings change (sort_on)
        Cache::forget('all_servers');
        Cache::forget('all_active_servers');
        Cache::forget('all_shared');
        Cache::forget('all_seedboxes');
        Cache::forget('all_reseller');
        Cache::forget('all_misc');
        Cache::forget('all_domains');

        Settings::setSettingsToSession(Settings::getSettings());

        if ($update){
            return redirect()->route('settings.index')
                ->with('success', 'Settings Updated Successfully.');
        }

        return redirect()->route('settings.index')
            ->with('error', 'Settings failed to update.');
    }

}
