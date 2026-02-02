@section("title", "Add an IP address")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add IP Address</h2>
            <div class="page-actions">
                <a href="{{ route('IPs.index') }}" class="btn btn-outline-secondary">Back to IPs</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('IPs.store') }}" method="POST">
            @csrf

            <!-- IP Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">IP Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">IP Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="ip_type">
                                <option value="ipv4" selected>IPv4</option>
                                <option value="ipv6">IPv6</option>
                            </select>
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
                                @foreach ($seed_boxes as $seed_box)
                                    <option value="{{ $seed_box['id'] }}">{{ $seed_box['title'] }} (Seed box)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Add IP Address</button>
        </form>
    </div>
</x-app-layout>
