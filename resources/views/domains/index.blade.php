@section('title', 'Domain names')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Domains</h2>
            <div class="page-actions">
                <x-export-buttons route="export.domains" />
                <a href="{{ route('domains.create') }}" class="btn btn-primary">Add domain</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="domain-table">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Provider</th>
                            <th>Price</th>
                            <th class="text-center">Due In</th>
                            <th class="text-center">Since</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($domains))
                        @foreach($domains as $domain)
                        <tr>
                            <td class="fw-medium">
                                <a href="https://{{ $domain->domain }}.{{ $domain->extension }}" class="text-decoration-none" target="_blank">
                                    {{ $domain->domain }}.{{ $domain->extension }}
                                </a>
                            </td>
                            <td class="text-nowrap">{{ $domain->provider->name }}</td>
                            <td class="text-nowrap">
                                {{ $domain->price->price }}
                                <small class="text-muted">{{ $domain->price->currency }}</small>
                            </td>
                            <td class="text-center text-nowrap">
                                {{ number_format(now()->diffInDays(Carbon\Carbon::parse($domain->price->next_due_date), false), 0) }}d
                            </td>
                            <td class="text-center text-nowrap">{{ $domain->owned_since }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('domains.show', $domain->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('domains.edit', $domain->id) }}" class="btn btn-sm btn-action" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $domain->id }}" data-title="{{ $domain->domain }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No domains found</td>
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
        <x-slot name="uri">domains</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#domain-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [5]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: { previous: "Prev", next: "Next" },
                    emptyTable: "No domains found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
