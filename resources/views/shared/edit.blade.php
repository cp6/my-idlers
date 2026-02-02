@section("title", "{$shared->main_domain} edit")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $shared->main_domain }}</h2>
            <div class="page-actions">
                <a href="{{ route('shared.index') }}" class="btn btn-outline-secondary">Back to shared</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('shared.update', $shared->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Domain</label>
                            <input type="text" class="form-control" name="domain" value="{{ $shared->main_domain }}" required>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="shared_type">
                                @foreach(['ApisCP', 'Centos', 'cPanel', 'Direct Admin', 'Webmin', 'Moss', 'Other', 'Plesk', 'Run cloud', 'Vesta CP', 'Virtual min'] as $type)
                                    <option value="{{ $type }}" {{ $shared->shared_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Dedicated IP</label>
                            <input type="text" class="form-control" name="dedicated_ip" value="{{ $shared->ips[0]->address ?? '' }}" maxlength="255">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billing -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Billing</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Provider</label>
                            <select class="form-select" name="provider_id">
                                @foreach (App\Models\Providers::all() as $provider)
                                    <option value="{{ $provider->id }}" {{ $shared->provider->id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $shared->price->price }}" min="0" max="9999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $shared->price->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1" {{ $shared->price->term == 1 ? 'selected' : '' }}>Monthly</option>
                                <option value="2" {{ $shared->price->term == 2 ? 'selected' : '' }}>Quarterly</option>
                                <option value="3" {{ $shared->price->term == 3 ? 'selected' : '' }}>Half annual</option>
                                <option value="4" {{ $shared->price->term == 4 ? 'selected' : '' }}>Annual</option>
                                <option value="5" {{ $shared->price->term == 5 ? 'selected' : '' }}>Biennial</option>
                                <option value="6" {{ $shared->price->term == 6 ? 'selected' : '' }}>Triennial</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location_id">
                                @foreach (App\Models\Locations::all() as $location)
                                    <option value="{{ $location->id }}" {{ $shared->location->id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Promo Price</label>
                            <select class="form-select" name="was_promo">
                                <option value="0" {{ $shared->was_promo == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $shared->was_promo == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ $shared->owned_since }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ $shared->price->next_due_date }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Limits -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Limits</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Domains</label>
                            <input type="number" class="form-control" name="domains" value="{{ $shared->domains_limit }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Sub Domains</label>
                            <input type="number" class="form-control" name="sub_domains" value="{{ $shared->subdomains_limit }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk (GB)</label>
                            <input type="number" class="form-control" name="disk" value="{{ $shared->disk_as_gb }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Email</label>
                            <input type="number" class="form-control" name="email" value="{{ $shared->email_limit }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Bandwidth (GB)</label>
                            <input type="number" class="form-control" name="bandwidth" value="{{ $shared->bandwidth }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">FTP</label>
                            <input type="number" class="form-control" name="ftp" value="{{ $shared->ftp_limit }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Databases</label>
                            <input type="number" class="form-control" name="db" value="{{ $shared->db_limit }}" min="0" max="999999">
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
                                    <option value="{{ $label->id }}" {{ isset($shared->labels[0]->label->id) && $shared->labels[0]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($shared->labels[1]->label->id) && $shared->labels[1]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($shared->labels[2]->label->id) && $shared->labels[2]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($shared->labels[3]->label->id) && $shared->labels[3]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $shared->active === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">I still have this hosting</label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Update Shared Hosting</button>
        </form>
    </div>
</x-app-layout>
