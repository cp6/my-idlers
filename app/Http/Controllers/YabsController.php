<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Yabs;
use App\Process;
use App\Models\DiskSpeed;
use App\Models\NetworkSpeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class YabsController extends Controller
{
    public function index()
    {
        $yabs = DB::table('yabs as y')
            ->join('servers as s', 'y.server_id', '=', 's.id')
            ->Join('disk_speed as ds', 'y.id', '=', 'ds.id')
            ->get(['y.*', 's.hostname', 'ds.*']);

        return view('yabs.index', compact(['yabs']));
    }

    public function create()
    {
        $Servers = Server::all();
        return view('yabs.create', compact(['Servers']));
    }

    public function store(Request $request)
    {
        $process = new Process();

        $yabs = $process->yabsOutputAsJson($request->server_id, $request->yabs);

        if (isset($yabs['error_id'])) {
            return back()->withErrors(["yabs" => 'Problem inserting YABs. Error id ' . $yabs['error_id']])->withInput();
            //return redirect()->route('yabs.index')->with('error', 'Problem inserting YABs. Error id ' . $yabs['error_id']);
        }
        //No errors, do insert

        $yabs_id = Str::random(8);

        Yabs::create([
            'id' => $yabs_id,
            'server_id' => $request->server_id,
            'has_ipv6' => $yabs['has_ipv6'],
            'aes' => $yabs['aes'],
            'vm' => $yabs['vm'],
            'output_date' => $yabs['output_date'],
            'cpu_cores' => $yabs['cpu_cores'],
            'cpu_freq' => $yabs['cpu_freq'],
            'cpu_model' => $yabs['cpu'],
            'ram' => $yabs['ram'],
            'ram_type' => $yabs['ram_type'],
            'ram_mb' => $yabs['ram_mb'],
            'disk' => $yabs['disk'],
            'disk_type' => $yabs['disk_type'],
            'disk_gb' => $yabs['disk_gb'],
            'gb5_single' => $yabs['GB5_single'],
            'gb5_multi' => $yabs['GB5_mult'],
            'gb5_id' => $yabs['GB5_id']
        ]);

        DiskSpeed::create([
            'id' => $yabs_id,
            'server_id' => $request->server_id,
            'd_4k' => $yabs['disk_speed']['4k_total'],
            'd_4k_type' => $yabs['disk_speed']['4k_total_type'],
            'd_4k_as_mbps' => $yabs['disk_speed']['4k_total_mbps'],
            'd_64k' => $yabs['disk_speed']['64k_total'],
            'd_64k_type' => $yabs['disk_speed']['64k_total_type'],
            'd_64k_as_mbps' => $yabs['disk_speed']['64k_total_mbps'],
            'd_512k' => $yabs['disk_speed']['512k_total'],
            'd_512k_type' => $yabs['disk_speed']['512k_total_type'],
            'd_512k_as_mbps' => $yabs['disk_speed']['512k_total_mbps'],
            'd_1m' => $yabs['disk_speed']['1m_total'],
            'd_1m_type' => $yabs['disk_speed']['1m_total_type'],
            'd_1m_as_mbps' => $yabs['disk_speed']['1m_total_mbps']
        ]);

        foreach ($yabs['network_speed'] as $y) {
            NetworkSpeed::create([
                'id' => $yabs_id,
                'server_id' => $request->server_id,
                'location' => $y['location'],
                'send' => $y['send'],
                'send_type' => $y['send_type'],
                'send_as_mbps' => $y['send_type_mbps'],
                'receive' => $y['receive'],
                'receive_type' => $y['receive_type'],
                'receive_as_mbps' => $y['receive_type_mbps']
            ]);
        }

        $update_server = DB::table('servers')
            ->where('id', $request->server_id)
            ->update([
                'ram' => $yabs['ram'],
                'ram_type' => $yabs['ram_type'],
                'ram_as_mb' => ($yabs['ram_type'] === 'GB') ? ($yabs['ram'] * 1024) : $yabs['ram'],
                'disk' => $yabs['disk'],
                'disk_type' => $yabs['disk_type'],
                'disk_as_gb' => ($yabs['disk_type'] === 'TB') ? ($yabs['disk'] * 1024) : $yabs['disk'],
                'cpu' => $yabs['cpu_cores'],
                'has_yabs' => 1
            ]);

        Cache::forget('all_active_servers');//all servers cache
        Cache::forget('non_active_servers');//all servers cache

        return redirect()->route('yabs.index')
            ->with('success', 'Success inserting YABs');
    }

    public function show(Yabs $yab)
    {
        $yab = DB::table('yabs as y')
            ->join('servers as s', 'y.server_id', '=', 's.id')
            ->join('disk_speed as ds', 'y.id', '=', 'ds.id')
            ->where('y.id', '=', $yab->id)
            ->get(['y.*', 's.hostname', 'ds.*']);

        $network = DB::table('network_speed')
            ->where('id', '=', $yab[0]->id)
            ->get();

        return view('yabs.show', compact(['yab', 'network']));
    }

    public function destroy(Yabs $yab)
    {
        $id = $yab->id;
        $yabs = Yabs::find($id);
        $yabs->delete();

        $disk = DiskSpeed::find($id);
        $disk->delete();

        $network = NetworkSpeed::find($id);
        $network->delete();

        $update_server = DB::table('servers')
            ->where('id', $yab->server_id)
            ->update(['has_yabs' => 0]);

        return redirect()->route('yabs.index')
            ->with('success', 'YABs was deleted Successfully.');
    }
}
