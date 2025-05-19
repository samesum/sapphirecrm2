<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <title>@stack('title') | {{ get_settings('system_name') }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}" />

    <!-- Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    <!-- Plugins -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icon-picker/fontawesome-iconpicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icon-picker/icons/fontawesome-all.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/summernote/summernote-lite.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/tagify-master/dist/tagify.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/nice-select/nice-select.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/select2/select2.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/daterangepicker/daterangepicker.css') }}" />

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/variables/default.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/variables/dark.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}" />
    @stack('css')
</head>


<body>

    @include('sidebar')

    <div class="ol-sidebar-content">
        @include('header')
        <div class="ol-body-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- jQuery UI -->
    <script type="text/javascript" src="{{ asset('assets/global/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="{{ asset('assets/global/datatable/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/datatable/datatables.min.js') }}"></script>

    <!-- Select JS -->
    <script type="text/javascript" src="{{ asset('assets/global/select2/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/nice-select/nice-select.min.js') }}"></script>

    <!-- Additional Libraries -->
    <script type="text/javascript" src="{{ asset('assets/global/summernote/summernote-lite.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/icon-picker/fontawesome-iconpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Other Libraries -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.contextMenu.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/loader.js') }}"></script>

    {{-- Duration picker --}}
    <script src="{{ asset('assets/global/duration-picker/DurationPickerMaker.js') }}"></script>

    <!-- Your Custom Scripts -->
    <script type="text/javascript" src='{{ asset('assets/js/index.global.js') }}'></script>
    <script type="text/javascript" src="{{ asset('assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/charts.js') }}"></script>


    @include('modal')
    @include('toastr')
    @include('script')
    @include('initiate')
    @include('components.datatable')
    @stack('js')
</body>

</html>
