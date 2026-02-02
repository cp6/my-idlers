@section('title') {{'Reset Password'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <div class="auth-header">
            <h1 class="auth-title">Reset Password</h1>
            <p class="auth-subtitle">Enter your new password below</p>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email" class="form-label">Email address</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" 
                           class="form-control" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">New password</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" 
                           class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm new password</label>
                <div class="input-group">
                    <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password_confirmation" type="password" name="password_confirmation" 
                           class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary auth-btn">
                Reset password
            </button>
        </form>
    </x-auth-card>
</x-guest-layout>
