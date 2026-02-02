@section("title", "Add a misc service")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add Misc Service</h2>
            <div class="page-actions">
                <a href="{{ route('misc.index') }}" class="btn btn-outline-secondary">Back to misc</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('misc.store') }}" method="POST">
            @csrf

            <!-- Service Information -->
            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Service Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-6 col-md-6 col-lg-2">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="9.99" min="0" max="9999" step="0.01" required>
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
                    </div>
                    <div class="row g-3 mt-1">
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

            <button type="submit" class="btn btn-primary mb-4">Add Misc Service</button>
        </form>
    </div>
</x-app-layout>
