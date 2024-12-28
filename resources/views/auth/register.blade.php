@section('title') {{'Register'}} @endsection
<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <h3 class="text-center mb-5">@if (config()->has('app.name')) {{ config('app.name') }} @else My idlers @endif Register</h3>
        <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
            <div class="form-floating mb-3">
                <x-label for="name" :value="__('Name')"/>

                <x-input id="name" class="form-control  " type="text" name="name" :value="old('name')" required
                         autofocus/>
            </div>

            <!-- Email Address -->
            <div class="form-floating mb-3">
                <x-label for="email" :value="__('Email')"/>

                <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                         autofocus/>
            </div>

            <!-- Password -->
            <div class="form-floating mb-3">
                <x-label for="password" :value="__('Password')"/>

                <x-input id="password" class="form-control"
                         type="password"
                         name="password"
                         required autocomplete="new-password"/>
            </div>

            <!-- Confirm Password -->
            <div class="form-floating mb-3">
                <x-label for="password_confirmation" :value="__('Confirm Password')"/>

                <x-input id="password_confirmation" class="form-control"
                         type="password"
                         name="password_confirmation" required/>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a class="text-decoration-none" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
                <div class="col-12">
                    <x-button class="mt-4 w-100 btn btn-lg btn-primary">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
