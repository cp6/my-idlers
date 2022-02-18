@section('title') {{'DNS'}} @endsection
@section('style')
    <x-modal-style></x-modal-style>
@endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('DNS') }}
    </x-slot>
    <div class="container" id="app">
        <x-delete-confirm-modal></x-delete-confirm-modal>
        <x-card class="shadow mt-3">
            <a href="{{ route('dns.create') }}" class="btn btn-primary mb-3">Add DNS</a>
            <x-success-alert></x-success-alert>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">Type</th>
                        <th class="text-nowrap">Hostname</th>
                        <th class="text-nowrap">Address</th>
                        <th class="text-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($dn))
                        @foreach($dn as $dns)
                            <tr>
                                <td class="text-nowrap">{{ $dns->dns_type}}</td>
                                <td class="text-nowrap">{{ $dns->hostname}}</td>
                                <td class="text-nowrap">{{ $dns->address}}</td>
                                <td class="text-nowrap">
                                    <form action="{{ route('dns.destroy', $dns->id) }}" method="POST">
                                        <a href="{{ route('dns.show', $dns->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-eye" title="view"></i></a>
                                        <a href="{{ route('dns.edit', $dns->id) }}"
                                           class="text-body mx-1">
                                            <i class="fas fa-pen" title="edit"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <i class="fas fa-trash text-danger ms-3" @click="modalForm"
                                           id="btn-{{$dns->hostname}}" title="{{$dns->id}}"></i>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="px-4 py-2 border text-red-500" colspan="3">No DNSes found.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </x-card>
        @if(Session::has('timer_version_footer') && Session::get('timer_version_footer') === 1)
            <p class="text-muted mt-4 text-end"><small>
                    Built on Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}
                    )</small>
            </p>
        @endif
    </div>
    <x-modal-delete-script>
        <x-slot name="uri">dns</x-slot>
    </x-modal-delete-script>
</x-app-layout>
