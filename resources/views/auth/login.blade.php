@section('title') {{'Login'}} @endsection

@section('style')
<style>
    :root {
        --bs-link-color: #525252 !important;
        --bs-link-hover-color: #a3a3a3 !important;
    }

    *, *::before, *::after { box-sizing: border-box; }

    html, body {
        height: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #000 !important;
    }

    body {
        background: #000 !important;
        min-height: 100vh !important;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        display: block !important;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .login-logo { margin-bottom: 1.25rem; }
    .login-logo svg { width: 32px; height: 32px; }

    .login-title {
        color: #fff !important;
        font-size: 1.25rem !important;
        font-weight: 500 !important;
        margin: 0 0 1.5rem 0 !important;
        letter-spacing: -0.025em !important;
        background: none !important;
        -webkit-text-fill-color: #fff !important;
    }

    .login-form { width: 100%; max-width: 280px; }

    .form-input {
        width: 100%;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        color: #fff !important;
        background: #0a0a0a !important;
        border: 1px solid #262626 !important;
        border-radius: 6px;
        margin-bottom: 0.5rem;
        font-family: inherit;
        transition: border-color 0.15s ease;
    }

    .form-input::placeholder { color: #525252 !important; }

    .form-input:focus {
        outline: none !important;
        border-color: #404040 !important;
        box-shadow: none !important;
    }

    .btn-login {
        width: 100%;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #000 !important;
        background: #fff !important;
        border: none !important;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 0.25rem;
        font-family: inherit;
        transition: background 0.15s ease;
    }

    .btn-login:hover { background: #e5e5e5 !important; }
    .btn-login:active { background: #d4d4d4 !important; }
    .btn-login:focus { outline: none !important; box-shadow: none !important; }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        width: 100%;
        max-width: 280px;
    }

    .remember-group { display: flex; align-items: center; gap: 0.5rem; }

    .custom-checkbox {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 14px;
        height: 14px;
        border: 1px solid #404040;
        border-radius: 3px;
        background: transparent;
        cursor: pointer;
        position: relative;
        margin: 0;
        transition: all 0.15s ease;
    }

    .custom-checkbox:hover { border-color: #525252; }

    .custom-checkbox:checked {
        background: #fff;
        border-color: #fff;
    }

    .custom-checkbox:checked::after {
        content: '';
        position: absolute;
        left: 4px;
        top: 1px;
        width: 4px;
        height: 8px;
        border: solid #000;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .custom-checkbox:focus { outline: none; }

    .form-footer label {
        color: #525252 !important;
        font-size: 0.8125rem !important;
        cursor: pointer;
        -webkit-text-fill-color: #525252 !important;
        transition: color 0.15s ease;
    }

    .form-footer label:hover {
        color: #737373 !important;
        -webkit-text-fill-color: #737373 !important;
    }

    .forgot-link,
    .forgot-link:link,
    .forgot-link:visited,
    a.forgot-link {
        color: #525252 !important;
        font-size: 0.8125rem !important;
        text-decoration: none !important;
        -webkit-text-fill-color: #525252 !important;
        transition: color 0.15s ease;
    }

    .forgot-link:hover,
    a.forgot-link:hover {
        color: #a3a3a3 !important;
        -webkit-text-fill-color: #a3a3a3 !important;
    }

    .alert-box {
        width: 100%;
        max-width: 280px;
        padding: 0.625rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        margin-bottom: 1rem;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #fca5a5 !important;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        color: #86efac !important;
    }
</style>
@endsection

<x-guest-layout>
    <div class="login-container">
        <div class="login-logo">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="2" y="3" width="20" height="18" rx="2" stroke="#737373" stroke-width="1.5"/>
                <line x1="2" y1="7.5" x2="22" y2="7.5" stroke="#737373" stroke-width="1.5"/>
                <circle cx="5" cy="5.25" r="1" fill="#f87171"/>
                <circle cx="8" cy="5.25" r="1" fill="#fbbf24"/>
                <circle cx="11" cy="5.25" r="1" fill="#4ade80"/>
                <line x1="5" y1="11" x2="19" y2="11" stroke="#404040" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="5" y1="14.5" x2="14" y2="14.5" stroke="#404040" stroke-width="1.5" stroke-linecap="round"/>
                <line x1="5" y1="18" x2="11" y2="18" stroke="#404040" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>

        <h1 class="login-title">Log in to My Idlers</h1>

        @if (session('status'))
            <div class="alert-box alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-box alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf
            <input type="email" name="email" class="form-input" placeholder="Email" value="{{ old('email') }}" required autofocus>
            <input type="password" name="password" class="form-input" placeholder="Password" required>
            <button type="submit" class="btn-login">Continue</button>
        </form>

        <div class="form-footer">
            <div class="remember-group">
                <input type="checkbox" name="remember" id="remember" class="custom-checkbox">
                <label for="remember">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
        </div>
    </div>
</x-guest-layout>
