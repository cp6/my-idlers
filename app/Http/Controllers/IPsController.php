<?php

namespace App\Http\Controllers;

use App\Models\IPs;
use App\Models\Reseller;
use App\Models\Server;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IPsController extends Controller
{
    public function index()
    {
        $ips = IPs::all();
        return view('ips.index', compact(['ips']));
    }

    public function create()
    {
        $Servers = Server::all();
        $Shareds = Shared::all();
        $Resellers = Reseller::all();
        return view('ips.create', compact(['Servers', 'Shareds', 'Resellers']));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
