@section("title", "Edit Domain")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $domain_info->domain }}.{{ $domain_info->extension }}</h2>
            <div class="page-actions">
                <a href="{{ route('domains.index') }}" class="btn btn-outline-secondary">Back to domains</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('domains.update', $domain_info->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Domain Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Domain Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Domain</label>
                            <input type="text" class="form-control" name="domain" value="{{ $domain_info->domain }}" required>
                        </div>
                        <div class="col-12 col-lg-3">
                            <label class="form-label">Extension</label>
                            <input type="text" class="form-control" name="extension" value="{{ $domain_info->extension }}" maxlength="255">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nameservers -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Nameservers</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <label class="form-label">NS1</label>
                            <input type="text" class="form-control" name="ns1" value="{{ $domain_info->ns1 }}" maxlength="255">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">NS2</label>
                            <input type="text" class="form-control" name="ns2" value="{{ $domain_info->ns2 }}" maxlength="255">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label class="form-label">NS3</label>
                            <input type="text" class="form-control" name="ns3" value="{{ $domain_info->ns3 }}" maxlength="255">
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
                                    <option value="{{ $provider->id }}" {{ $domain_info->provider->id == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $domain_info->price->price }}" min="0" max="9999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $domain_info->price->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1" {{ $domain_info->price->term == 1 ? 'selected' : '' }}>Monthly</option>
                                <option value="2" {{ $domain_info->price->term == 2 ? 'selected' : '' }}>Quarterly</option>
                                <option value="3" {{ $domain_info->price->term == 3 ? 'selected' : '' }}>Half annual</option>
                                <option value="4" {{ $domain_info->price->term == 4 ? 'selected' : '' }}>Annual</option>
                                <option value="5" {{ $domain_info->price->term == 5 ? 'selected' : '' }}>Biennial</option>
                                <option value="6" {{ $domain_info->price->term == 6 ? 'selected' : '' }}>Triennial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ $domain_info->owned_since }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ $domain_info->price->next_due_date }}">
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
                                    <option value="{{ $label->id }}" {{ isset($domain_info->labels[0]->label) && $domain_info->labels[0]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 2</label>
                            <select class="form-select" name="label2">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($domain_info->labels[1]->label) && $domain_info->labels[1]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 3</label>
                            <select class="form-select" name="label3">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($domain_info->labels[2]->label) && $domain_info->labels[2]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label">Label 4</label>
                            <select class="form-select" name="label4">
                                <option value="">None</option>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" {{ isset($domain_info->labels[3]->label) && $domain_info->labels[3]->label->id == $label->id ? 'selected' : '' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $domain_info->active === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">I still have this domain</label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Update Domain</button>
        </form>
    </div>
</x-app-layout>
