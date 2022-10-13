@section("title", "Edit {$dn->hostname} {$dn->dns_type} DNS")
<x-app-layout>
    <x-slot name="header">
        Edit {{ $dn->hostname }} {{$dn->dns_type}} record
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">DNS information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('dns.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('dns.update', $dn->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mt-4">
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Hostname</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="hostname"
                                   value="{{ $dn->hostname }}">
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Address</span></div>
                            <input type="text" name="address" class="form-control" minlength="1"
                                   maxlength="124" value="{{ $dn->address }}">
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                            <select class="form-control" name="dns_type">
                                @foreach (App\Models\DNS::$dns_types as $item)
                                    <option
                                        value="{{ $item }}" {{ ( $item == $dn->dns_type) ? 'selected' : '' }}> {{ $item }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label1</x-slot>
                            @if(isset($labels[0]->id))
                                <x-slot name="current">{{$labels[0]->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label2</x-slot>
                            @if(isset($labels[1]->id))
                                <x-slot name="current">{{$labels[1]->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label3</x-slot>
                            @if(isset($labels[2]->id))
                                <x-slot name="current">{{$labels[2]->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label4</x-slot>
                            @if(isset($labels[3]->id))
                                <x-slot name="current">{{$labels[3]->id}}</x-slot>
                            @endif
                        </x-labels-select>
                    </div>
                </div>
                <div class="row mt-2">
                    <p>Related to:</p>
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server</span></div>
                            <select class="form-control" name="server_id">
                                <option value="null"></option>
                                @foreach ($Servers as $server)
                                    <option
                                        value="{{ $server['id'] }}" {{($server['id'] == $dn->server_id)? 'selected':''}}>
                                        {{ $server['hostname'] }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Shared</span></div>
                            <select class="form-control" name="shared_id">
                                <option value="null"></option>
                                @foreach ($Shareds as $shared)
                                    <option
                                        value="{{ $shared['id'] }}" {{($shared['id'] == $dn->shared_id)? 'selected':''}}>
                                        {{ $shared['hostname'] }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Reseller</span></div>
                            <select class="form-control" name="reseller_id">
                                <option value="null"></option>
                                @foreach ($Resellers as $reseller)
                                    <option
                                        value="{{ $reseller['id'] }}" {{($reseller['id'] == $dn->reseller_id)? 'selected':''}}>
                                        {{ $reseller['hostname'] }}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Domain</span></div>
                            <select class="form-control" name="domain_id">
                                <option value="null"></option>
                                @foreach ($Domains as $domain)
                                    <option
                                        value="{{ $domain['id'] }}" {{($domain['id'] == $dn->domain_id)? 'selected':''}}>
                                        {{ $domain['domain'] }}.{{$domain['extension']}}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update DNS</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
