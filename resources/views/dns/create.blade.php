@section("title", "Add a DNS")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add DNS Record</h2>
            <div class="page-actions">
                <a href="{{ route('dns.index') }}" class="btn btn-outline-secondary">Back to DNS</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('dns.store') }}" method="POST">
            @csrf

            <!-- DNS Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">DNS Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Hostname</label>
                            <input type="text" class="form-control" name="hostname" required>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="dns_type">
                                <option value="A" selected>A</option>
                                <option value="AAAA">AAAA</option>
                                <option value="DNAME">DNAME</option>
                                <option value="MX">MX</option>
                                <option value="NS">NS</option>
                                <option value="SOA">SOA</option>
                                <option value="TXT">TXT</option>
                                <option value="URI">URI</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Labels -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Labels</h5>
                    <span class="text-muted small">Optional</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php $labels = App\Models\Labels::all(); @endphp
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 1</label>
                            <select class="form-select" name="label1">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}">{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related To -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Related To</h5>
                    <span class="text-muted small">Optional</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Server</label>
                            <select class="form-select" name="server_id">
                                <option value="null"></option>
                                @foreach ($Servers as $server)
                                    <option value="{{ $server['id'] }}">{{ $server['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Shared</label>
                            <select class="form-select" name="shared_id">
                                <option value="null"></option>
                                @foreach ($Shareds as $shared)
                                    <option value="{{ $shared['id'] }}">{{ $shared['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Reseller</label>
                            <select class="form-select" name="reseller_id">
                                <option value="null"></option>
                                @foreach ($Resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}">{{ $reseller['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Domain</label>
                            <select class="form-select" name="domain_id">
                                <option value="null"></option>
                                @foreach ($Domains as $domain)
                                    <option value="{{ $domain['id'] }}">{{ $domain['domain'] }}.{{ $domain['extension'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Add DNS Record</button>
        </form>
    </div>
</x-app-layout>
