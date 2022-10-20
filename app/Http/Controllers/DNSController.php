<?php

namespace App\Http\Controllers;

use App\Models\DNS;
use App\Models\Labels;
use App\Models\Reseller;
use App\Models\Server;
use App\Models\Domains;
use App\Models\Shared;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DNSController extends Controller
{
    public function index()
    {
        $dn = DB::table('d_n_s')->get();
        return view('dns.index', compact(['dn']));
    }

    public function create()
    {
        $Servers = Server::all();
        $Domains = Domains::all();
        $Shareds = Shared::all();
        $Resellers = Reseller::all();
        return view('dns.create', compact(['Servers', 'Domains', 'Shareds', 'Resellers']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hostname' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'dns_type' => 'required|string',
            'label1' => 'sometimes|nullable|string',
            'label2' => 'sometimes|nullable|string',
            'label3' => 'sometimes|nullable|string',
            'label4' => 'sometimes|nullable|string',
        ]);

        $dns_id = Str::random(8);

        DNS::create([
            'id' => $dns_id,
            'hostname' => $request->hostname,
            'dns_type' => $request->dns_type,
            'address' => $request->address,
            'server_id' => ($request->server_id !== 'null') ? $request->server_id : null,
            'shared_id' => ($request->shared_id !== 'null') ? $request->shared_id : null,
            'reseller_id' => ($request->reseller_id !== 'null') ? $request->reseller_id : null,
            'domain_id' => ($request->domain_id !== 'null') ? $request->domain_id : null
        ]);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $dns_id);

        Cache::forget('dns_count');

        return redirect()->route('dns.index')
            ->with('success', 'DNS Created Successfully.');
    }

    public function show(DNS $dn)
    {
        $dns = DNS::findOrFail($dn->id);

        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $dn->id)
            ->get(['labels.label']);

        return view('dns.show', compact(['dn', 'dns', 'labels']));
    }

    public function edit(DNS $dn)
    {
        $Servers = Server::all();
        $Domains = Domains::all();
        $Shareds = Shared::all();
        $Resellers = Reseller::all();
        $dn = DNS::findOrFail($dn->id);
        $labels = DB::table('labels_assigned as l')
            ->join('labels', 'l.label_id', '=', 'labels.id')
            ->where('l.service_id', '=', $dn->id)
            ->get(['labels.id']);

        return view('dns.edit', compact(['dn', 'labels', 'Servers', 'Domains', 'Shareds', 'Resellers']));
    }

    public function update(Request $request, DNS $dn)
    {
        $request->validate([
            'hostname' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'dns_type' => 'required|string',
            'label1' => 'sometimes|nullable|string',
            'label2' => 'sometimes|nullable|string',
            'label3' => 'sometimes|nullable|string',
            'label4' => 'sometimes|nullable|string',
        ]);

        $dn->update([
            'hostname' => $request->hostname,
            'dns_type' => $request->dns_type,
            'address' => $request->address,
            'server_id' => ($request->server_id !== 'null') ? $request->server_id : null,
            'shared_id' => ($request->shared_id !== 'null') ? $request->shared_id : null,
            'reseller_id' => ($request->reseller_id !== 'null') ? $request->reseller_id : null,
            'domain_id' => ($request->domain_id !== 'null') ? $request->domain_id : null
        ]);

        Labels::deleteLabelsAssignedTo($dn->id);

        Labels::insertLabelsAssigned([$request->label1, $request->label2, $request->label3, $request->label4], $dn->id);

        return redirect()->route('dns.index')
            ->with('success', 'DNS updated Successfully.');
    }

    public function destroy(DNS $dn)
    {
        $id = $dn->id;
        $items = DNS::find($id);

        $items->delete();

        Cache::forget('dns_count');

        Labels::deleteLabelsAssignedTo($id);

        return redirect()->route('dns.index')
            ->with('success', 'DNS was deleted Successfully.');
    }
}
