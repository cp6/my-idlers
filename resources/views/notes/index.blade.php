@section('title', 'Notes')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Notes</h2>
            <div class="page-actions">
                <a href="{{ route('notes.create') }}" class="btn btn-primary">Add note</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="notes-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Type</th>
                            <th>Note Preview</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($notes[0]))
                        @foreach($notes as $n)
                        <tr>
                            <td class="fw-medium text-nowrap">
                                @if(!is_null($n->server))
                                    {{ $n->server->hostname }}
                                @elseif(!is_null($n->shared))
                                    {{ $n->shared->main_domain }}
                                @elseif(!is_null($n->reseller))
                                    {{ $n->reseller->main_domain }}
                                @elseif(!is_null($n->domain))
                                    {{ $n->domain->domain }}.{{ $n->domain->extension }}
                                @elseif(!is_null($n->dns))
                                    {{ $n->dns->dns_type }} {{ $n->dns->hostname }}
                                @elseif(!is_null($n->ip))
                                    {{ $n->ip->address }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-type">
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
                                </span>
                            </td>
                            <td>{{ strlen($n->note) > 80 ? substr($n->note, 0, 80) . "…" : $n->note }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('notes.show', $n->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('notes.edit', $n->id) }}" class="btn btn-sm btn-action" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $n->id }}" 
                                            data-title="{{ strlen($n->note) > 24 ? substr($n->note, 0, 24) . '…' : $n->note }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No notes found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <x-details-footer></x-details-footer>
        <x-delete-confirm-modal></x-delete-confirm-modal>
    </div>

    <x-modal-delete-script>
        <x-slot name="uri">notes</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#notes-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [3]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: { previous: "Prev", next: "Next" },
                    emptyTable: "No notes found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
