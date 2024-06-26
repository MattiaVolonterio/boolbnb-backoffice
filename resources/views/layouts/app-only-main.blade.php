<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>{{ env('APP_NAME', 'BoolBnB') }} - @yield('title', 'My page') </title>

    @vite('resources/js/app.js')

    @yield('payment-js')

    @yield('css')
</head>

<body>
    <div class="wrapper">
        <main>
            @yield('content')
        </main>
    </div>

    @yield('js')

</body>

</html>
