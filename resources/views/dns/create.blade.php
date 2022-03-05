@section('title') {{'Insert DNS'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new DNS') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">DNS information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('dns.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
            <form action="{{ route('dns.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-4 mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Hostname</span></div>
                            <input type="text"
                                   class="form-control"
                                   name="hostname" required>
                            @error('name') <span class="text-red-500">{{ $message }}
                    </span>@enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mb-4">
                        <x-text-input>
                            <x-slot name="title">address</x-slot>
                            <x-slot name="name">address</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                            <select class="form-control" name="dns_type">
                                <option value="A" selected>A</option>
                                <option value="AAAA">AAAA</option>
                                <option value="DNAME">DNAME</option>
                                <option value="MX">MX</option>
                                <option value="NS">NS</option>
                                <option value="SOA">SOA</option>
                                <option value="TXT">TXT</option>
                                <option value="URI">URI</option>
                            </select></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label1</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label2</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label3</x-slot>
                        </x-labels-select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <x-labels-select>
                            <x-slot name="title">label</x-slot>
                            <x-slot name="name">label4</x-slot>
                        </x-labels-select>
                    </div>
                </div>
                <div class="row">
                    <p>Related to:</p>
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Server</span></div>
                            <select class="form-control" name="server_id">
                                <option value="null"></option>
                                @foreach ($Servers as $server)
                                    <option value="{{ $server['id'] }}">
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
                                    <option value="{{ $shared['id'] }}">
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
                                    <option value="{{ $reseller['id'] }}">
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
                                    <option value="{{ $domain['id'] }}">
                                        {{ $domain['domain'] }}.{{$domain['extension']}}
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert DNS</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
