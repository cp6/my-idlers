@section('title', 'Locations')
<x-app-layout>
    <x-slot name="header">
        {{ __('Locations') }}
    </x-slot>
    <div class="container" id="app">
        <x-card class="shadow mt-3">
            <a href="{{ route('locations.create') }}" class="btn btn-primary mb-3">Add a location</a>
            <x-response-alerts></x-response-alerts>
            <table class="table table-bordered" id="locations-table">
                <thead class="table-light">
                <tr class="bg-gray-100">
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($locations))
                    @foreach($locations as $location)
                        <tr>
                            <td class="text-nowrap">{{ $location->name }}</td>
                            <td class="text-nowrap">
                                <form action="{{ route('locations.destroy', $location->id) }}" method="POST">
                                    <a href="{{ route('locations.show', $location->id) }}"
                                       class="text-body mx-1">
                                        <i class="fas fa-eye" title="view"></i></a>
                                    <i class="fas fa-trash text-danger ms-3" @click="confirmDeleteModal"
                                       id="{{$location->id}}" title="{{$location->name}}"></i>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-4 py-2 border text-red-500" colspan="3">No locations found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </x-card>
        <x-details-footer></x-details-footer>
        <x-delete-confirm-modal></x-delete-confirm-modal>
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">locations</x-slot>
    </x-modal-delete-script>
    @section('scripts')
        <script>
            window.addEventListener('load', function () {
                $('#locations-table').DataTable({
                    "pageLength": 15,
                    "lengthMenu": [5, 10, 15, 25, 30, 50, 75, 100],
                    "columnDefs": [
                        {"orderable": false, "targets": 1}
                    ],
                    "initComplete": function () {
                        $('.dataTables_length,.dataTables_filter').addClass('mb-2');
                        $('.dataTables_paginate').addClass('mt-2');
                        $('.dataTables_info').addClass('mt-2 text-muted ');
                    }
                });
            })
        </script>
    @endsection
</x-app-layout>
