<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>{{ config('app.name', __('Code Challenge')) }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <!-- JS -->
        <script src="{{ version_asset('/js/vendor.js') }}"></script>
        <script src="{{ version_asset('/js/app.js') }}"></script>

        <!-- CSS -->
        <link href="{{ version_asset('/css/vendor.css') }}" rel="stylesheet">
        <link href="{{ version_asset('/css/app.css') }}" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-expand-md navbar-dark">
            <div class="flex-row d-flex">
                <h1 class="title">{{ config('app.name', __('Code Challenge')) }}</h1>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-left">
                <nav class="sidebar sidebar-expanded sidebar-offcanvas navbar-dark" role="navigation">
                    <x-menu namespace="challenge" />
                </nav>
                <main class="main col p-0">
                    <div class="flex-center position-rel">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        
    </body>
</html>
