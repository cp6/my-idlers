@section("title", "Edit {$dn->hostname} {$dn->dns_type} DNS")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $dn->hostname }} {{ $dn->dns_type }}</h2>
            <div class="page-actions">
                <a href="{{ route('dns.index') }}" class="btn btn-outline-secondary">Back to DNS</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('dns.update', $dn->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- DNS Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">DNS Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Hostname</label>
                            <input type="text" class="form-control" name="hostname" value="{{ $dn->hostname }}" required>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" value="{{ $dn->address }}">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="dns_type">
                                @foreach (App\Models\DNS::$dns_types as $type)
                                    <option value="{{ $type }}" {{ $dn->dns_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
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
                        @php $allLabels = App\Models\Labels::all(); @endphp
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 1</label>
                            <select class="form-select" name="label1">
                                <option value="">None</option>
                                @foreach ($allLabels as $label)
                                    <option value="{{ $label->id }}" {{ isset($labels[0]->id) && $labels[0]->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($allLabels as $label)
                                    <option value="{{ $label->id }}" {{ isset($labels[1]->id) && $labels[1]->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($allLabels as $label)
                                    <option value="{{ $label->id }}" {{ isset($labels[2]->id) && $labels[2]->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($allLabels as $label)
                                    <option value="{{ $label->id }}" {{ isset($labels[3]->id) && $labels[3]->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
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
                                    <option value="{{ $server['id'] }}" {{ $server['id'] == $dn->server_id ? 'selected' : '' }}>{{ $server['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Shared</label>
                            <select class="form-select" name="shared_id">
                                <option value="null"></option>
                                @foreach ($Shareds as $shared)
                                    <option value="{{ $shared['id'] }}" {{ $shared['id'] == $dn->shared_id ? 'selected' : '' }}>{{ $shared['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Reseller</label>
                            <select class="form-select" name="reseller_id">
                                <option value="null"></option>
                                @foreach ($Resellers as $reseller)
                                    <option value="{{ $reseller['id'] }}" {{ $reseller['id'] == $dn->reseller_id ? 'selected' : '' }}>{{ $reseller['hostname'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Domain</label>
                            <select class="form-select" name="domain_id">
                                <option value="null"></option>
                                @foreach ($Domains as $domain)
                                    <option value="{{ $domain['id'] }}" {{ $domain['id'] == $dn->domain_id ? 'selected' : '' }}>{{ $domain['domain'] }}.{{ $domain['extension'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Update DNS Record</button>
        </form>
    </div>
</x-app-layout>
