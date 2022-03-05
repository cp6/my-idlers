<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset(Auth::user()->api_token))
        <meta name="api_token" content="{{ Auth::user()->api_token }}">
    @endif

    <title>@yield('title') - My idlers</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa.min.css') }}">

    @yield('css_links')
    @yield('style')

    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>

    @yield('scripts')
</head>
<body class="font-sans antialiased">
<div class="container-fluid">
    @include('layouts.navigation')
</div>
@if(isset($header))
    <div class="container">
        <h3 class="ms-2 mt-3">
            {{ $header}}
        </h3>
    </div>
@endif

<div class="container">
    {{ $slot }}
</div>
</body>
</html>
