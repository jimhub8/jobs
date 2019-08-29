<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Example -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="Auth::user()">
    <title>{{ config('app.name', 'MFT') }}</title>
    <link rel="icon" href="/storage/logo1.jpg">

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    {{--  <link href='https://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet'>  --}}
     <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/mtf.css') }}" rel="stylesheet"> --}}
    @stack('styles')
</head>
<body>
        {{-- @include('reports::app') --}}
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

{{--  <script src="{{ asset('vuetify/js/vuetify.js') }}"></script>  --}}
</body>
</html>
