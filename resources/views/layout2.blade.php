<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Majota | Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">

    @include('components.styles')

    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        @yield('content2')
    </div>

    @include('components.scripts')

    @stack('scripts')
</body>

</html>
