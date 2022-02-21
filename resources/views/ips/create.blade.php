@section('title') {{'Insert IP address'}} @endsection
<x-app-layout>
    <x-slot name="header">
        {{ __('Insert a new IP') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <h4 class="mb-3">IP information</h4>
            <x-back-button>
                <x-slot name="href">{{ route('IPs.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-errors-alert></x-errors-alert>
            <form action="{{ route('IPs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4">
                        <x-text-input>
                            <x-slot name="title">IP address</x-slot>
                            <x-slot name="name">address</x-slot>
                        </x-text-input>
                    </div>
                    <div class="col-12 col-lg-4 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Type</span></div>
                            <select class="form-control" name="ip_type">
                                <option value="ipv4" selected>IPv4</option>
                                <option value="ipv6">IPv6</option>
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <p>Attached to:</p>
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
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Insert IP</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
