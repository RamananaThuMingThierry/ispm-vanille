<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="icon" href="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset(config('public_path.public_path').'utiles/logo.png') }}" type="image/x-icon">
        <meta name="author" content="RAMANANA Thu Ming Thierry" />
        <meta name="description" content="Vanille" />
        <title>@yield('titre', __('title.default'))</title>
        @include('backoffice.layout.styles')
        @stack('styles')
    </head>
    <body class="sb-nav-fixed">
        @include('backoffice.layout.nav')
        @include('backoffice.layout.toats')

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                @include('backoffice.layout.sidebar')
            </div>
            <div id="layoutSidenav_content" style="background-color: rgb(189, 189, 189)">
                <main>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
                @include('backoffice.layout.footer')
            </div>
        </div>
        @include('backoffice.modal.contact_us')
        @include('backoffice.layout.scripts')
        @stack('scripts')
    </body>
</html>
