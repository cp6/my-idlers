@section("title", "Edit note")
<x-app-layout>
    <x-slot name="header">
        {{ __('Edit note') }}
    </x-slot>
    <div class="container">
        <x-card class="shadow mt-3">
            <x-back-button>
                <x-slot name="href">{{ route('notes.index') }}</x-slot>
                Go back
            </x-back-button>
            <x-response-alerts></x-response-alerts>
            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12 mb-4">
                        <textarea class="form-control" id="note" name="note" rows="6">{{ $note->note }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <p>This note is for:</p>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">Service</span></div>
                            <select class="form-control" name="service_id">
                                @foreach ($servers as $server)
                                    <option value="{{ $server['id'] }}"
                                            @if ($server['id'] === $note->service_id) selected @endif>
                                        {{ $server['hostname'] }} (Server)
                                    </option>
                                @endforeach
                                @foreach ($shareds as $shared)
                                    <option value="{{ $shared['id'] }}"
                                            @if ($shared['id'] === $note->service_id) selected @endif>
                                        {{ $shared['main_domain'] }} (Shared)
                                    </option>
                                @endforeach
                                @foreach ($resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}"
                                            @if ($reseller['id'] === $note->service_id) selected @endif>
                                        {{ $reseller['main_domain'] }} (Reseller)
                                    </option>
                                @endforeach
                                @foreach ($domains as $seed_box)
                                    <option value="{{ $seed_box['id'] }}"
                                            @if ($seed_box['id'] === $note->service_id) selected @endif>
                                        {{ $seed_box['domain'] }}.{{ $seed_box['extension'] }} (Domain)
                                    </option>
                                @endforeach
                                @foreach ($dns as $dn)
                                    <option value="{{ $dn['id'] }}"
                                            @if ($dn['id'] === $note->service_id) selected @endif>
                                        {{ $dn['dns_type'] }}.{{ $dn['hostname'] }} (DNS)
                                    </option>
                                @endforeach
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip['id'] }}"
                                            @if ($ip['id'] === $note->service_id) selected @endif>
                                        {{ $ip['address'] }} (IP)
                                    </option>
                                @endforeach
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <x-submit-button>Update note</x-submit-button>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
