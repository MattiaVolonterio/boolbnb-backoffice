<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>{{ env('APP_NAME', 'BoolBnB') }} - @yield('title', 'My page') </title>

    @vite('resources/js/app.js')

    @yield('css')

    @yield('payment-js')
</head>

<body>
    <div class="wrapper">
        @include('layouts.partials.header')

        <main>
            @yield('content')
        </main>

        @include('layouts.partials.footer')
        @yield('modal')
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
