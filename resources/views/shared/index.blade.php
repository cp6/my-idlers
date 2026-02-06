@section('title', 'Shared hosting')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Shared Hosting</h2>
            <div class="page-actions">
                <x-export-buttons route="export.shared" />
                <a href="{{ route('shared.create') }}" class="btn btn-primary">Add shared hosting</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="shared-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Provider</th>
                            <th class="text-center">Disk</th>
                            <th class="text-center">Domains</th>
                            <th>Price</th>
                            <th class="text-center">Due</th>
                            <th class="text-center">Since</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($shared))
                        @foreach($shared as $row)
                        <tr>
                            <td class="fw-medium">{{ $row->main_domain }}</td>
                            <td><span class="badge badge-type">{{ $row->shared_type }}</span></td>
                            <td class="text-nowrap">{{ $row->location->name }}</td>
                            <td class="text-nowrap">{{ $row->provider->name }}</td>
                            <td class="text-center text-nowrap">{{ $row->disk_as_gb }}<small class="text-muted">GB</small></td>
                            <td class="text-center">{{ $row->domains_limit }}</td>
                            <td class="text-nowrap">
                                {{ $row->price->price }} {{ $row->price->currency }}
                                <small class="text-muted">{{ \App\Process::paymentTermIntToString($row->price->term) }}</small>
                            </td>
                            <td class="text-center text-nowrap">{{ Carbon\Carbon::parse($row->price->next_due_date)->diffForHumans() }}</td>
                            <td class="text-center text-nowrap">{{ $row->owned_since }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('shared.show', $row->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('shared.edit', $row->id) }}" class="btn btn-sm btn-action" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $row->id }}" data-title="{{ $row->main_domain }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">No shared hosting found</td>
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
        <x-slot name="uri">shared</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#shared-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [9]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: { previous: "Prev", next: "Next" },
                    emptyTable: "No shared hosting found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
