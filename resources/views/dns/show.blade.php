@section("title", "{$dns->hostname} {$dns->dns_type} DNS")
<x-app-layout>
    <x-slot name="header">
        {{ __('DNS details') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <h2>{{ $dns->hostname}}</h2>
                    <code>@foreach($labels as $label)
                            @if($loop->last)
                                {{$label->label}}
                            @else
                                {{$label->label}},
                            @endif
                        @endforeach</code>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <h6 class="text-muted pe-lg-4">{{$dns->id }}</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="table-responsive">
                        <table class="table table-borderless text-nowrap">
                            <tbody>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Type</td>
                                <td>{{ $dns->dns_type }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Name</td>
                                <td>{{ $dns->hostname }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Address</td>
                                <td><code>{{ $dns->address }}</code></td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Server</td>
                                <td>
                                    @if(isset($dns->server_id))
                                        <a href="{{route('servers.show', $dns->server_id )}}">{{ $dns->server_id }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Shared</td>
                                <td>
                                    @if(isset($dns->shared_id))
                                        <a href="{{route('shared.show', $dns->shared_id )}}">{{ $dns->shared_id }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Reseller</td>
                                <td>
                                    @if(isset($dns->reseller_id))
                                        <a href="{{route('resellers.show', $dns->reseller_id )}}">{{ $dns->reseller_id }}</a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Domain</td>
                                <td>
                                    @if(isset($dns->domain_id))
                                        <a href="{{route('domains.show', $dns->domain_id )}}">{{ $dns->domain_id }}</a>
                                    @endif</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Inserted</td>
                                <td>
                                    @if(!is_null($dns->created_at))
                                        {{ date_format(new DateTime($dns->created_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 font-bold text-muted">Updated</td>
                                <td>
                                    @if(!is_null($dns->updated_at))
                                        {{ date_format(new DateTime($dns->updated_at), 'jS M y g:i a') }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('dns.index') }}"
               class="btn btn-success btn-sm mx-2">
                Go back
            </a>
            <a href="{{ route('dns.edit', $dns->id) }}"
               class="btn btn-primary btn-sm mx-2">
                Edit
            </a>
        </x-card>
    </div>
</x-app-layout>
