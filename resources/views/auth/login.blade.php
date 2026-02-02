@section('title') {{'Login'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <div class="auth-header">
            <h1 class="auth-title">@if (config()->has('app.name')) {{ config('app.name') }} @else My Idlers @endif</h1>
            <p class="auth-subtitle">Sign in to your account</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
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

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" 
                           class="form-control" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <div class="form-options">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                Sign in
            </button>
        </form>

        @if (Route::has('register'))
            <div class="auth-footer">
                <p>Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
            </div>
        @endif
    </x-auth-card>
</x-guest-layout>
