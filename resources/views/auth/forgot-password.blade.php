@section('title') {{'Forgot Password'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <div class="auth-header">
            <h1 class="auth-title">Forgot Password?</h1>
            <p class="auth-subtitle">No worries, we'll send you reset instructions</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-control" placeholder="you@example.com" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                Send reset link
            </button>
        </form>

        <div class="auth-footer">
            <p><a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i>Back to sign in</a></p>
        </div>
    </x-auth-card>
</x-guest-layout>
