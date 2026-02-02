@section("title", "Edit note")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit Note</h2>
            <div class="page-actions">
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">Back to notes</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('notes.update', $note->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Note Content -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Note Content</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" rows="6" required>{{ $note->note }}</textarea>
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
                                    <option value="{{ $server['id'] }}" {{ $server['id'] === $note->service_id ? 'selected' : '' }}>{{ $server['hostname'] }} (Server)</option>
                                @endforeach
                                @foreach ($shareds as $shared)
                                    <option value="{{ $shared['id'] }}" {{ $shared['id'] === $note->service_id ? 'selected' : '' }}>{{ $shared['main_domain'] }} (Shared)</option>
                                @endforeach
                                @foreach ($resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}" {{ $reseller['id'] === $note->service_id ? 'selected' : '' }}>{{ $reseller['main_domain'] }} (Reseller)</option>
                                @endforeach
                                @foreach ($domains as $domain)
                                    <option value="{{ $domain['id'] }}" {{ $domain['id'] === $note->service_id ? 'selected' : '' }}>{{ $domain['domain'] }}.{{ $domain['extension'] }} (Domain)</option>
                                @endforeach
                                @foreach ($dns as $dn)
                                    <option value="{{ $dn['id'] }}" {{ $dn['id'] === $note->service_id ? 'selected' : '' }}>{{ $dn['dns_type'] }} {{ $dn['hostname'] }} (DNS)</option>
                                @endforeach
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip['id'] }}" {{ $ip['id'] === $note->service_id ? 'selected' : '' }}>{{ $ip['address'] }} (IP)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Update Note</button>
        </form>
    </div>
</x-app-layout>
