@section("title", "Add a shared hosting")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add Shared Hosting</h2>
            <div class="page-actions">
                <a href="{{ route('shared.index') }}" class="btn btn-outline-secondary">Back to shared</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('shared.store') }}" method="POST">
            @csrf

            <!-- Basic Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Domain</label>
                            <input type="text" class="form-control" name="domain" required>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="shared_type">
                                <option value="ApisCP">ApisCP</option>
                                <option value="Centos">Centos</option>
                                <option value="cPanel" selected>cPanel</option>
                                <option value="Direct Admin">Direct Admin</option>
                                <option value="Webmin">Webmin</option>
                                <option value="Moss">Moss</option>
                                <option value="Other">Other</option>
                                <option value="Plesk">Plesk</option>
                                <option value="Run cloud">Run cloud</option>
                                <option value="Vesta CP">Vesta CP</option>
                                <option value="Virtual min">Virtual min</option>
                            </select>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Dedicated IP</label>
                            <input type="text" class="form-control" name="dedicated_ip" maxlength="255">
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
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="2.50" min="0" max="9999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ Session::get('default_currency') == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1">Monthly</option>
                                <option value="2">Quarterly</option>
                                <option value="3">Half annual</option>
                                <option value="4">Annual</option>
                                <option value="5">Biennial</option>
                                <option value="6">Triennial</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location_id">
                                @foreach (App\Models\Locations::all() as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Promo Price</label>
                            <select class="form-select" name="was_promo">
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ Carbon\Carbon::now()->addDays(30)->format('Y-m-d') }}">
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
                            <input type="number" class="form-control" name="domains" value="10" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Sub Domains</label>
                            <input type="number" class="form-control" name="sub_domains" value="20" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Disk (GB)</label>
                            <input type="number" class="form-control" name="disk" value="50" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Email</label>
                            <input type="number" class="form-control" name="email" value="100" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Bandwidth (GB)</label>
                            <input type="number" class="form-control" name="bandwidth" value="500" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">FTP</label>
                            <input type="number" class="form-control" name="ftp" value="100" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <label class="form-label">Databases</label>
                            <input type="number" class="form-control" name="db" value="100" min="0" max="999999">
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

            <button type="submit" class="btn btn-primary mb-4">Add Shared Hosting</button>
        </form>
    </div>
</x-app-layout>
