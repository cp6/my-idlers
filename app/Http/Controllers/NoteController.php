<?php

namespace App\Http\Controllers;

use App\Models\DNS;
use App\Models\Domains;
use App\Models\IPs;
use App\Models\Note;
use App\Models\Reseller;
use App\Models\Server;
use App\Models\Shared;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::allNotes();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $servers = Server::all();
        $shareds = Shared::all();
        $resellers = Reseller::all();
        $domains = Domains::all();
        $dns = DNS::all();
        $ips = IPs::all();

        return view('notes.create', compact(['servers', 'shareds', 'resellers', 'domains', 'dns', 'ips']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|string|size:8',
            'note' => 'required|string',
        ]);

        try {
            $note_id = Str::random(8);

            $a = Note::create([
                'id' => $note_id,
                'service_id' => $request->service_id,
                'note' => $request->note
            ]);

        } catch (\Exception $e) {

            if ($e->getCode() === "23000") {
                $message = "A note already exists for this service";
            } else {
                $message = "Error inserting note";
            }

            return redirect()->route('notes.create')
                ->withInput($request->input())->with('error', $message);
        }

        Cache::forget('all_notes');

        return redirect()->route('notes.index')
            ->with('success', 'Note created successfully.');
    }

    public function edit(Note $note)
    {
        $note = Note::note($note->service_id);
        $servers = Server::all();
        $shareds = Shared::all();
        $resellers = Reseller::all();
        $domains = Domains::all();
        $dns = DNS::all();
        $ips = IPs::all();

        return view('notes.edit', compact(['note', 'servers', 'shareds', 'resellers', 'domains', 'dns', 'ips']));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'service_id' => 'required|string|size:8',
            'note' => 'required|string'
        ]);

        $note->update([
            'service_id' => $request->service_id,
            'note' => $request->note
        ]);

        Cache::forget('all_notes');
        Cache::forget("note.$note->service_id");

        return redirect()->route('notes.index')
            ->with('success', 'Note was updated successfully.');
    }

    public function show(Note $note)
    {
        $note = Note::note($note->service_id);
        return view('notes.show', compact(['note']));
    }

    public function destroy(Note $note)
    {
        if ($note->delete()) {
            Cache::forget("all_notes");
            Cache::forget("note.$note->service_id");

            return redirect()->route('notes.index')
                ->with('success', 'Note was deleted successfully.');
        }

        return redirect()->route('notes.index')
            ->with('error', 'Note was not deleted.');

    }

}
