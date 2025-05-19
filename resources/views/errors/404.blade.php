<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ get_phrase('404 not found') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- UI Icon -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/variables/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<style>
    .back-btn {
        display: inline flex;
        align-items: center;
        padding: 8px 18px;
        background: #1b84ff;
        font-weight: 500;
        color: #fff;
        border-radius: 6px;
        line-height: 20px;
        gap: 4px;
        font-size: 12px;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: #3291ff;
        color: #fff;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-center align-items-center vh-100">
                <div>
                    <div class="d-flex justify-content-center mb-20px">
                        <img src="{{ asset('assets/images/404.png') }}" alt="">
                    </div>
                    <h4 class="mb-12px fs-20px lh-20 text-center title">{{ get_phrase('404 not Found') }}</h4>
                    <p class="text-center mb-20px sub-title lh-24 fs-16px">{{ get_phrase('The page you requested could not be found.') }}</p>
                    <div class="text-center">
                        <a href="{{ url()->previous() }}" class="back-btn">
                            <span>
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.862652 8.47139L5.52932 13.1381C5.65505 13.2595 5.82345 13.3267 5.99825 13.3252C6.17305 13.3237 6.34026 13.2535 6.46386 13.1299C6.58747 13.0063 6.65758 12.8391 6.6591 12.6643C6.66062 12.4895 6.59342 12.3211 6.47198 12.1954L2.94332 8.66672L14.6673 8.66672C14.8441 8.66672 15.0137 8.59648 15.1387 8.47146C15.2637 8.34643 15.334 8.17687 15.334 8.00005C15.334 7.82324 15.2637 7.65367 15.1387 7.52865C15.0137 7.40362 14.8441 7.33339 14.6673 7.33339L2.94332 7.33339L6.47199 3.80472C6.53566 3.74322 6.58645 3.66966 6.62139 3.58832C6.65633 3.50699 6.67472 3.41951 6.67549 3.33099C6.67626 3.24247 6.65939 3.15468 6.62587 3.07275C6.59235 2.99082 6.54284 2.91638 6.48025 2.85379C6.41765 2.7912 6.34322 2.74169 6.26129 2.70817C6.17936 2.67465 6.09157 2.65778 6.00305 2.65855C5.91453 2.65932 5.82705 2.67771 5.74572 2.71265C5.66438 2.74759 5.59082 2.79838 5.52932 2.86205L0.862652 7.52872C0.737671 7.65374 0.667462 7.82328 0.667462 8.00005C0.667462 8.17683 0.737671 8.34637 0.862652 8.47139Z"
                                        fill="white" />
                                </svg>
                            </span>
                            <span>
                                {{ get_phrase('Go back') }}
                            </span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
