@section("title", "Note $note->id")
<x-app-layout>
    <x-slot name="header">
        {{ __('Note') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 mb-2">
                    <h2>
                        @if(!is_null($note->server))
                            {{$note->server->hostname}} (server)
                        @elseif(!is_null($note->shared))
                            {{$note->shared->main_domain}} (shared)
                        @elseif(!is_null($note->reseller))
                            {{$note->reseller->main_domain}} (reseller)
                        @elseif(!is_null($note->domain))
                            {{$note->domain->domain}}.{{$note->domain->extension}} (domain)
                        @elseif(!is_null($note->dns))
                            {{$note->dns->dns_type}} {{$note->dns->hostname}} (DNS)
                        @elseif(!is_null($note->ip))
                            {{$note->ip->address}} (IP)
                        @endif
                    </h2>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12 px-lg-4">
                    <code>{{$note->note}}</code>
                </div>
            </div>
            <x-back-btn>
                <x-slot name="route">{{ route('notes.index') }}</x-slot>
            </x-back-btn>
            <x-edit-btn>
                <x-slot name="route">{{ route('notes.edit', $note->id) }}</x-slot>
            </x-edit-btn>
        </x-card>
    </div>
</x-app-layout>
