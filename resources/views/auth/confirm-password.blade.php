@section('title', 'Confirm Password')
<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Confirm Password</h1>
                <p class="auth-subtitle">This is a secure area. Please confirm your password before continuing.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100">Confirm</button>
            </form>
        </div>
    </div>
</x-guest-layout>
