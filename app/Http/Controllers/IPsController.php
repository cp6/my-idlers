<?php

namespace App\Http\Controllers;

use App\Models\DNS;
use App\Models\IPs;
use App\Models\Reseller;
use App\Models\SeedBoxes;
use App\Models\Server;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IPsController extends Controller
{
    public function index()
    {
        $ips = IPs::all();
        return view('ips.index', compact(['ips']));
    }

    public function create()
    {
        $servers = Server::all();
        $shareds = Shared::all();
        $resellers = Reseller::all();
        $seed_boxes = SeedBoxes::all();
        return view('ips.create', compact(['servers', 'shareds', 'resellers', 'seed_boxes']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|ip|min:2',
            'ip_type' => 'required|string|size:4',
            'service_id' => 'required|string'
        ]);

        $ip_id = Str::random(8);

        IPs::create([
            'id' => $ip_id,
            'address' => $request->address,
            'is_ipv4' => ($request->ip_type === 'ipv4') ? 1 : 0,
            'service_id' => $request->service_id,
            'active' => 1
        ]);

        return redirect()->route('IPs.index')
            ->with('success', 'IP address created Successfully.');
    }

    public function destroy(IPs $IP)
    {
        if ($IP->delete()) {
            return redirect()->route('IPs.index')
                ->with('success', 'IP address was deleted Successfully.');
        }
        return redirect()->route('IPs.index')
            ->with('error', 'IP was not deleted.');
    }
}
