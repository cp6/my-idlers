@section("title", "Add a note")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add Note</h2>
            <div class="page-actions">
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Back to notes</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <!-- Note Content -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Note Content</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" rows="6" required>{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attached To -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Attached To</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Service</label>
                            <select class="form-select" name="service_id">
                                @foreach ($servers as $server)
                                    <option value="{{ $server['id'] }}">{{ $server['hostname'] }} (Server)</option>
                                @endforeach
                                @foreach ($shareds as $shared)
                                    <option value="{{ $shared['id'] }}">{{ $shared['main_domain'] }} (Shared)</option>
                                @endforeach
                                @foreach ($resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}">{{ $reseller['main_domain'] }} (Reseller)</option>
                                @endforeach
                                @foreach ($domains as $domain)
                                    <option value="{{ $domain['id'] }}">{{ $domain['domain'] }}.{{ $domain['extension'] }} (Domain)</option>
                                @endforeach
                                @foreach ($dns as $dn)
                                    <option value="{{ $dn['id'] }}">{{ $dn['dns_type'] }} {{ $dn['hostname'] }} {{ $dn['address'] }} (DNS)</option>
                                @endforeach
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip['id'] }}">{{ $ip['address'] }} (IP)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Add Note</button>
        </form>
    </div>
</x-app-layout>
