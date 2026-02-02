@section("title", "Edit account")
<x-app-layout>
    <div class="container">
        <div class="page-header">
            <h2 class="page-title">Account Settings</h2>
        </div>

        <x-response-alerts></x-response-alerts>

        <form action="{{ route('account.update', Auth::user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" maxlength="255" 
                                   value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" maxlength="255" 
                                   value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card content-card mb-4">
                <div class="card-header card-section-header">
                    <h5 class="card-section-title mb-0">API Access</h5>
                </div>
                <div class="card-body">
                    <label class="form-label">API Token</label>
                    <div class="input-group">
                        <input type="text" class="form-control font-monospace" value="{{ Auth::user()->api_token }}" readonly>
                        <button type="button" class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ Auth::user()->api_token }}')">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                    <small class="text-muted">Use this token to authenticate API requests</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-4">Update Account</button>
        </form>

        <x-details-footer></x-details-footer>
    </div>
</x-app-layout>
