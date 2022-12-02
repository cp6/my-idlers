@section('title', 'Notes')
<x-app-layout>
    <x-slot name="header">
        {{ __('Notes') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <x-card class="shadow mt-3">
            <a href="{{ route('notes.create') }}" class="btn btn-primary mb-3">Add a note</a>
            <x-response-alerts></x-response-alerts>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">Service</th>
                        <th class="text-nowrap">Type</th>
                        <th class="text-nowrap">Note Preview</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($notes[0]))
                        @foreach($notes as $n)
                            <tr>
                                <td class="text-nowrap">
                                    @if(!is_null($n->server))
                                        {{$n->server->hostname}}
                                    @elseif(!is_null($n->shared))
                                        {{$n->shared->main_domain}}
                                    @elseif(!is_null($n->reseller))
                                        {{$n->reseller->main_domain}}
                                    @elseif(!is_null($n->domain))
                                        {{$n->domain->domain}}.{{$n->domain->extension}}
                                    @elseif(!is_null($n->dns))
                                        {{$n->dns->dns_type}} {{$n->dns->hostname}}
                                    @elseif(!is_null($n->ip))
                                        {{$n->ip->address}}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if(!is_null($n->server))
                                        SERVER
                                    @elseif(!is_null($n->shared))
                                        SHARED
                                    @elseif(!is_null($n->reseller))
                                        RESELLER
                                    @elseif(!is_null($n->domain))
                                        DOMAIN
                                    @elseif(!is_null($n->dns))
                                        DNS
                                    @elseif(!is_null($n->ip))
                                        IP
                                    @endif
                                </td>
                                <td class="text-nowrap">{{strlen($n->note) > 80 ? substr($n->note,0,80)."…" : $n->note}}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('notes.destroy', $n->id) }}" method="POST">
                                        <a href="{{ route('notes.edit', $n->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-pen" title="edit"></i></a>
                                        <a href="{{ route('notes.show', $n->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-eye" title="view"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                           id="{{$n->id}}"
                                           title="{{strlen($n->note) > 24 ? substr($n->note,0,24)."…" : $n->note}}"></i>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="border text-red-500">No notes found.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        <x-details-footer></x-details-footer>
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">notes</x-slot>
    </x-modal-delete-script>
</x-app-layout>
