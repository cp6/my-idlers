@section('title') {{ $location->name }} {{'location'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Location details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $location->name }}</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $location->id }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                                @foreach($data as $l)
                                    <tr>
                                    <td class="py-2 text-muted">
                                        @if(isset($l->hostname))
                                            Server
                                        @elseif(isset($l->main_domain_shared))
                                            Shared
                                        @elseif(isset($l->main_domain_reseller))
                                            Reseller
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($l->hostname))
                                            <a href="{{ route('servers.show', $l->id) }}" class="text-decoration-none">{{$l->hostname}}</a>
                                        @elseif(isset($l->main_domain_shared))
                                            <a href="{{ route('shared.show', $l->id) }}" class="text-decoration-none">{{$l->main_domain_shared}}</a>
                                        @elseif(isset($l->main_domain_reseller))
                                            <a href="{{ route('reseller.show', $l->id) }}" class="text-decoration-none">{{$l->main_domain_reseller}}</a>
                                        @endif
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <x-back-button>
                <x-slot name="href">{{ route('locations.index') }}</x-slot>
                Go back
            </x-back-button>
        </x-card>
    </div>
</x-app-layout>
