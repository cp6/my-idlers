@section("title", "{$misc_data->name} edit")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Edit {{ $misc_data->name }}</h2>
            <div class="page-actions">
                <a href="{{ route('misc.index') }}" class="btn btn-outline-secondary">Back to misc</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('misc.update', $misc_data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Service Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Service Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $misc_data->name }}" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $misc_data->price->price }}" min="0" max="9999" step="0.01" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Currency</label>
                            <select class="form-select" name="currency">
                                @foreach (App\Models\Pricing::getCurrencyList() as $currency)
                                    <option value="{{ $currency }}" {{ $misc_data->price->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label">Term</label>
                            <select class="form-select" name="payment_term">
                                <option value="1" {{ $misc_data->price->term == 1 ? 'selected' : '' }}>Monthly</option>
                                <option value="2" {{ $misc_data->price->term == 2 ? 'selected' : '' }}>Quarterly</option>
                                <option value="3" {{ $misc_data->price->term == 3 ? 'selected' : '' }}>Half annual</option>
                                <option value="4" {{ $misc_data->price->term == 4 ? 'selected' : '' }}>Annual</option>
                                <option value="5" {{ $misc_data->price->term == 5 ? 'selected' : '' }}>Biennial</option>
                                <option value="6" {{ $misc_data->price->term == 6 ? 'selected' : '' }}>Triennial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mt-1">
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Owned Since</label>
                            <input type="date" class="form-control" name="owned_since" value="{{ $misc_data->owned_since }}">
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label">Next Due Date</label>
                            <input type="date" class="form-control" name="next_due_date" value="{{ $misc_data->price->next_due_date }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options & Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $misc_data->active === 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">I still have this service</label>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Update Misc Service</button>
        </form>
    </div>
</x-app-layout>
