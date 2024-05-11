<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>{{ env('APP_NAME', 'BoolBnB') }} - @yield('title', 'My page') </title>

    @vite('resources/js/app.js')

    @vite('resources/scss/side-bar-layout.scss')

    @yield('css')
</head>

<body>
    <div class="main-container">
        @include('layouts.partials.side-bar')
        <main class="main-content">
            {{-- navbar small --}}
            <div class="top-nav-small">
                <div class="logo-container-small">
                    <a href="{{ route('admin.dashboard') }}">
                        <img class="logo-img-small" src="{{ asset('img/logos/boolbnb-logo-2.png') }}" alt="logo">
                    </a>
                </div>

                {{-- offcanvas --}}
                <button class="offcanvas-button" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i
                        class="fa-solid fa-bars fa-xl"></i></button>
            </div>
            @yield('content')

            @yield('modal')
        </main>
    </div>

    @auth
        <script>
            const logoutLink = document.getElementById('logout-link');
            const logoutForm = document.getElementById('logout-form');

            logoutLink.addEventListener('click', (e) => {
                e.preventDefault();
                logoutForm.submit();
            });
        </script>
    @endauth

    @yield('js')

</body>

</html>
