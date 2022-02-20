<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = DB::table('settings')
            ->where('id', '=', 1)
            ->get();

        return view('settings.index', compact(['setting']));
    }

    public function update(Request $request, Settings $settings)
    {
        $request->validate([
            'show_versions_footer' => 'required|boolean',
            'show_server_value_ip' => 'required|boolean',
            'show_server_value_hostname' => 'required|boolean',
            'show_server_value_provider' => 'required|boolean',
            'show_server_value_location' => 'required|boolean',
            'show_server_value_price' => 'required|boolean',
            'show_server_value_yabs' => 'required|boolean'
        ]);

        DB::table('settings')
            ->where('id', 1)
            ->update([
                'show_versions_footer' => $request->show_versions_footer,
                'show_servers_public' => $request->show_servers_public,
                'show_server_value_ip' => $request->show_server_value_ip,
                'show_server_value_hostname' => $request->show_server_value_hostname,
                'show_server_value_provider' => $request->show_server_value_provider,
                'show_server_value_location' => $request->show_server_value_location,
                'show_server_value_price' => $request->show_server_value_price,
                'show_server_value_yabs' => $request->show_server_value_yabs
            ]);

        Session::put('timer_version_footer', $request->show_versions_footer);
        Session::put('show_servers_public', $request->show_servers_public);
        Session::put('show_server_value_ip', $request->show_server_value_ip);
        Session::put('show_server_value_hostname', $request->show_server_value_hostname);
        Session::put('show_server_value_price', $request->show_server_value_price);
        Session::put('show_server_value_yabs', $request->show_server_value_yabs);
        Session::put('show_server_value_provider', $request->show_server_value_provider);
        Session::put('show_server_value_location', $request->show_server_value_location);
        Session::save();

        return redirect()->route('settings.index')
            ->with('success', 'Settings Updated Successfully.');
    }

}
