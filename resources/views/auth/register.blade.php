@section('title') {{'Register'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <div class="auth-header">
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Get started with @if (config()->has('app.name')) {{ config('app.name') }} @else My Idlers @endif</p>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Full name</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-user"></i>
                    </span>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" 
                           class="form-control" placeholder="John Doe" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" 
                           class="form-control" placeholder="you@example.com" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" 
                           class="form-control" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm password</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                           class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                Create account
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </x-auth-card>
</x-guest-layout>
