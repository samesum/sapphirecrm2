<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Installer') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/install/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/install/css/style.css') }}">
</head>

<body class="install-body">

    <div class="row align-items-center justify-content-center h-100">
        <div class="col-sm-6">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('assets/install/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
</body>

</html>
