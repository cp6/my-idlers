@section('title', 'Labels')
<x-app-layout>
    <div class="container" id="app">
        <div class="page-header">
            <h2 class="page-title">Labels</h2>
            <div class="page-actions">
                <a href="{{ route('labels.create') }}" class="btn btn-primary">Add label</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <div class="content-card">
            <div class="table-responsive">
                <table class="table data-table" id="labels-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!empty($labels))
                        @foreach($labels as $label)
                        <tr>
                            <td class="fw-medium">{{ $label->label }}</td>
                            <td class="text-center text-nowrap">
                                <div class="action-buttons">
                                    <a href="{{ route('labels.show', $label->id) }}" class="btn btn-sm btn-action" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-action btn-delete" title="Delete"
                                            @click="confirmDeleteModal" id="{{ $label->id }}" data-title="{{ $label->label }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">No labels found</td>
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
        <x-slot name="uri">labels</x-slot>
    </x-modal-delete-script>

    @section('scripts')
    <script>
        window.addEventListener('load', function () {
            $.fn.dataTable.ext.errMode = 'none';
            $('#labels-table').DataTable({
                pageLength: 15,
                lengthMenu: [5, 10, 15, 25, 50, 100],
                columnDefs: [
                    {orderable: false, targets: [1]}
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_",
                    paginate: { previous: "Prev", next: "Next" },
                    emptyTable: "No labels found"
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
