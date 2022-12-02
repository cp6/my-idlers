@section("title", "Add a note")
<x-app-layout>
    <x-slot name="header">
        {{ __('Create a note') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('notes.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 mb-4">
                        <textarea class="form-control" id="note" name="note" rows="6">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <p>This note is for:</p>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Service</span></div>
                            <select class="form-control" name="service_id">
                                @foreach ($servers as $server)
                                    <option value="{{ $server['id'] }}">
                                        {{ $server['hostname'] }} (Server)
                                    </option>
                                @endforeach
                                @foreach ($shareds as $shared)
                                    <option value="{{ $shared['id'] }}">
                                        {{ $shared['main_domain'] }} (Shared)
                                    </option>
                                @endforeach
                                @foreach ($resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}">
                                        {{ $reseller['main_domain'] }} (Reseller)
                                    </option>
                                @endforeach
                                @foreach ($domains as $seed_box)
                                    <option value="{{ $seed_box['id'] }}">
                                        {{ $seed_box['domain'] }}.{{ $seed_box['extension'] }} (Domain)
                                    </option>
                                @endforeach
                                @foreach ($dns as $dn)
                                    <option value="{{ $dn['id'] }}">
                                        {{ $dn['dns_type'] }} {{ $dn['hostname'] }} {{ $dn['address'] }} (DNS)
                                    </option>
                                @endforeach
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip['id'] }}">
                                        {{ $ip['address'] }} (IP)
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Create note</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
