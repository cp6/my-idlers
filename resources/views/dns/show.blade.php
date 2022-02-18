@section('title') {{ $dns->hostname }} {{$dns->dns_type}} {{'dns'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('DNS details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('dns.index') }}</x-slot>
                Go back
            </x-back-button>
            <div class="table-responsive">
                <table class="table table-borderless text-nowrap">
                    <tbody>
                    <tr>
                        <td class="px-4 py-2 font-bold">Type</td>
                        <td>{{ $dns->dns_type }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Name</td>
                        <td>{{ $dns->hostname }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Address</td>
                        <td>{{ $dns->address }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Server</td>
                        <td>{{ $dns->server_id }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Shared</td>
                        <td>{{ $dns->shared_id }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Reseller</td>
                        <td>{{ $dns->reseller_id }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Domain</td>
                        <td>{{ $dns->domain_id }}</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Created on</td>
                        <td>
                            @if(!is_null($dns->created_at))
                                {{ date_format(new DateTime($dns->created_at), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Last updated</td>
                        <td>
                            @if(!is_null($dns->updated_at))
                                {{ date_format(new DateTime($dns->updated_at), 'jS F Y') }}
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
