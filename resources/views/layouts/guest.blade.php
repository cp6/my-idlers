<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - My idlers</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <x-form-style></x-form-style>

    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
</head>
<body>
{{ $slot }}
</body>
</html>
