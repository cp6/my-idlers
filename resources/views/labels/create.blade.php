@section("title", "Add label")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add Label</h2>
            <div class="page-actions">
                <a href="{{ route('labels.index') }}" class="btn btn-outline-secondary">Back to labels</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('labels.store') }}" method="POST">
            @csrf

            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Label Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Label</label>
                            <input type="text" class="form-control" name="label" required>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Add Label</button>
        </form>
    </div>
</x-app-layout>
