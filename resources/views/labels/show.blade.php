@section("title", "{$label->label} label")
<x-app-layout>
    <x-slot name="header">
        {{ __('Label details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $label->label }}</h2>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{ $label->id }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                                @foreach($labels as $label)
                                    <tr>
                                    <td class="py-2 text-muted">
                                        @if($label->service_type === 1)
                                            Server
                                        @elseif($label->service_type === 2)
                                            Shared
                                        @elseif($label->service_type === 3)
                                            Reseller
                                        @elseif($label->service_type === 4)
                                            Domain
                                        @endif
                                    </td>
                                    <td>
                                        @if($label->service_type === 1)
                                            <a href="{{ route('servers.show', $label->service_id) }}" class="text-decoration-none">{{$label->hostname}}</a>
                                        @elseif($label->service_type === 2)
                                            <a href="{{ route('shared.show', $label->service_id) }}" class="text-decoration-none">{{$label->shared}}</a>
                                        @elseif($label->service_type === 3)
                                            <a href="{{ route('reseller.show', $label->service_id) }}" class="text-decoration-none">{{$label->reseller}}</a>
                                        @elseif($label->service_type === 4)
                                            <a href="{{ route('domains.show', $label->service_id) }}" class="text-decoration-none">{{$label->domain}}.{{$label->extension}}</a>
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
                <x-slot name="href">{{ route('labels.index') }}</x-slot>
                Go back
            </x-back-button>
        </x-card>
    </div>
</x-app-layout>
