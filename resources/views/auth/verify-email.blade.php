@section('title', 'Verify Email')
<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Verify Your Email</h1>
                <p class="auth-subtitle">Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.</p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mb-3">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="d-flex flex-column gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Resend Verification Email</button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary w-100">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
