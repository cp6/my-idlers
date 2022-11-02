<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Yabs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class YabsController extends Controller
{
    public function index()
    {
        $yabs = Yabs::allYabs();
        return view('yabs.index', compact(['yabs']));
    }

    public function create()
    {
        abort(404);//Use new YABS json output POST method -s "URL"
    }

    public function store(Request $request)
    {
        abort(404);//Storing YABS now done through APiController
    }

    public function show(Yabs $yab)
    {
        $yab = Yabs::yabs($yab->id);
        return view('yabs.show', compact(['yab']));
    }

    public function destroy(Yabs $yab)
    {
        $yabs = Yabs::find($yab->id);
        $yabs->delete();

        if (Server::serverYabsAmount($yab->server_id) === 0) {
            DB::table('servers')
                ->where('id', $yab->server_id)
                ->update(['has_yabs' => 0]);
        }

        Cache::forget('all_yabs');
        Cache::forget("yabs.{$yab->id}");

        return redirect()->route('yabs.index')
            ->with('success', 'YABS was deleted Successfully.');
    }

    public function chooseYabsCompare()
    {
        $all_yabs = Yabs::allYabs();

        if (isset($all_yabs[1])){
            return view('yabs.choose-compare', compact('all_yabs'));
        }

        return redirect()->route('yabs.index')
            ->with('error', 'You need atleast 2 YABS to do a compare');
    }

    public function compareYabs(string $yabs1, string $yabs2)
    {
        $yabs1_data = Yabs::yabs($yabs1);

        if (count($yabs1_data) === 0) {
            abort(404);
        }

        $yabs2_data = Yabs::yabs($yabs2);

        if (count($yabs2_data) === 0) {
            abort(404);
        }

        return view('yabs.compare', compact('yabs1_data', 'yabs2_data'));
    }

    public function yabsToJson(Yabs $yab): array
    {
        $all_yabs = Yabs::yabs($yab->id)[0];
        return Yabs::buildYabsArray($all_yabs);
    }

}
