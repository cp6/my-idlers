@section("title", "{$seedbox_data->title} edit")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $seedbox_data->title }}</h2>
            <div class="page-actions">
                <a href="{{ route('seedboxes.index') }}" class="btn btn-outline-secondary">Back to seed boxes</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('seedboxes.update', $seedbox_data->id) }}" method="POST">
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
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $seedbox_data->title }}" required>
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Hostname</label>
                            <input type="text" class="form-control" name="hostname" value="{{ $seedbox_data->hostname }}">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="seed_box_type">
                                @foreach(['uTorrent', 'BitTorrent', 'ruTorrent', 'Transmission', 'qBitTorrent', 'Zona', 'Deluge', 'Other'] as $type)
                                    <option value="{{ $type }}" {{ $seedbox_data->seed_box_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
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
                                    <option value="{{ $provider->id }}" {{ $seedbox_data->provider->id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $seedbox_data->price->price }}" min="0" max="9999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $seedbox_data->price->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1" {{ $seedbox_data->price->term == 1 ? 'selected' : '' }}>Monthly</option>
                                <option value="2" {{ $seedbox_data->price->term == 2 ? 'selected' : '' }}>Quarterly</option>
                                <option value="3" {{ $seedbox_data->price->term == 3 ? 'selected' : '' }}>Half annual</option>
                                <option value="4" {{ $seedbox_data->price->term == 4 ? 'selected' : '' }}>Annual</option>
                                <option value="5" {{ $seedbox_data->price->term == 5 ? 'selected' : '' }}>Biennial</option>
                                <option value="6" {{ $seedbox_data->price->term == 6 ? 'selected' : '' }}>Triennial</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Location</label>
                            <select class="form-select" name="location_id">
                                @foreach (App\Models\Locations::all() as $location)
                                    <option value="{{ $location->id }}" {{ $seedbox_data->location_id == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Promo Price</label>
                            <select class="form-select" name="was_promo">
                                <option value="0" {{ $seedbox_data->was_promo == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ $seedbox_data->was_promo == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ $seedbox_data->owned_since }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ $seedbox_data->price->next_due_date }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Specifications</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <label class="form-label">Disk (GB)</label>
                            <input type="number" class="form-control" name="disk" value="{{ $seedbox_data->disk_as_gb }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label">Bandwidth (GB)</label>
                            <input type="number" class="form-control" name="bandwidth" value="{{ $seedbox_data->bandwidth }}" min="0" max="999999">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label">Port Speed (Mbps)</label>
                            <input type="number" class="form-control" name="port_speed" value="{{ $seedbox_data->port_speed }}" min="0" max="999999">
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
                        @for($i = 0; $i < 4; $i++)
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label {{ $i + 1 }}</label>
                            <select class="form-select" name="label{{ $i + 1 }}">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($seedbox_data->labels[$i]->label->id) && $seedbox_data->labels[$i]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $seedbox_data->active === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">I still have this seed box</label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Update Seed Box</button>
        </form>
    </div>
</x-app-layout>
