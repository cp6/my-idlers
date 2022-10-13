@section('title') {{'Locations'}} @endsection
@section('css_links')
    <link rel="stylesheet" href="{{ asset('css/datatables.bootstrap.min.css') }}">
@endsection
@section('style')
    <x-modal-style></x-modal-style>
@endsection
@section('scripts')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Locations') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
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
                                    <i class="fas fa-trash text-danger ms-3" @click="modalForm"
                                       id="btn-{{$location->name}}" title="{{$location->id}}"></i>
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
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
    <x-datatables-assets></x-datatables-assets>
    <script type="text/javascript">
        $(document).ready(function () {
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
        });
    </script>
    <x-modal-delete-script>
        <x-slot name="uri">locations</x-slot>
    </x-modal-delete-script>
</x-app-layout>
