@section("title", "Add an operating system")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Add Operating System</h2>
            <div class="page-actions">
                <a href="{{ route('os.index') }}" class="btn btn-outline-secondary">Back to OS</a>
            </div>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('os.store') }}" method="POST">
            @csrf

            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Operating System Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">OS Name</label>
                            <input type="text" class="form-control" name="os_name" required>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Add Operating System</button>
        </form>
    </div>
</x-app-layout>
