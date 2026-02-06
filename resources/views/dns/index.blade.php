@section("title", "DNS")
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">DNS</h2>
            <div class="page-actions">
                <x-export-buttons route="export.dns" />
                <a href="{{ route('dns.create') }}" class="btn btn-primary">Add DNS</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="dns-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Hostname</th>
                            <th>Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($dn[0]))
                        @foreach($dn as $dns)
                        <tr>
                            <td><span class="badge badge-type">{{ $dns->dns_type }}</span></td>
                            <td class="fw-medium">{{ $dns->hostname }}</td>
                            <td class="text-nowrap">{{ $dns->address }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('dns.show', $dns->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dns.edit', $dns->id) }}" class="btn btn-sm btn-action" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $dns->id }}" data-title="{{ $dns->hostname }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No DNS records found</td>
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
        <x-slot name="uri">dns</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#dns-table').DataTable({
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
                    emptyTable: "No DNS records found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
