@section('title') {{'Login'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

            <h3 class="text-center mb-5">@if (config()->has('app.name')) {{ config('app.name') }} @else My idlers @endif</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-3">
                    <x-label for="email" :value="__('Email')"/>

                    <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                             autofocus/>
                </div>
                <div class="form-floating mb-3">
                    <x-label for="password" :value="__('Password')"/>

                    <x-input id="password" class="form-control"
                             type="password"
                             name="password"
                             required autocomplete="current-password"/>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="remember-me" id="remember-me">
                    <label class="form-check-label" for="remember-me">
                        Remember me
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <x-button class="mt-4 w-100 btn btn-lg btn-primary">
                    {{ __('Login') }}
                </x-button>
            </form>

    </x-auth-card>
</x-guest-layout>
