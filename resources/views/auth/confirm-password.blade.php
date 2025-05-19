
<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_phrase('Confirm Password')}} | {{get_settings('system_title')}}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/bootstrap.min.css') }}">
    <!-- UI Icon -->
    <link rel="stylesheet" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/variables/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables/dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">


    <style>
        .min-height-100vh {
            min-height: 100vh;
        }

        .auth-form {
            width: 100%;
        }

        .auth-form .form-control {
            border: none;
            background: #eaf0f5;
            height: 44px;
            border-radius: 8px;
            padding: 16px;
            font-family: Inter;
            font-weight: 500;
            font-size: 12px;
            line-height: 100%;
            letter-spacing: 0%;
        }

        .auth-form .form-control::placeholder {
            color: #595C6D;
        }

        .auth-form .form-label {
            font-family: Inter;
            font-weight: 600;
            font-size: 14px;
            line-height: 100%;
            letter-spacing: 0%;
        }

        .auth-form .form-label-required {
            color: #4E97FF;
        }

        a {
            font-family: Inter;
            font-weight: 500;
            font-size: 12px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #4E97FF;
        }

        a:hover {
            color: #3c85eb;
        }

        .sub-title,
        .sub-title1,
        .sub-title2,
        .sub-title3 {
            font-family: Inter;
            font-weight: 500;
            font-size: 14px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #6B708A;
        }

        button,
        .ol2-btn-primary {
            font-family: Inter;
            font-weight: 600;
            font-size: 14px;
            line-height: 100%;
            letter-spacing: 0%;
        }

        .form-desk {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #254496;
            width: 100%;
            height: 100%;
            padding: 40px 100px;
            text-align: center;
            background-image: url('{{ asset('assets/images/login-desk-shape.png') }}');
            background-size: 65%;
            background-repeat: no-repeat;
            background-position-x: right;
        }

        .form-desk .desk-title {
            font-family: Inter;
            font-weight: 600;
            font-size: 38.48px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #F7FAFC;
            margin: 32px 0px;
        }

        .form-desk .desk-subtitle {
            font-family: Inter;
            font-weight: 400;
            font-size: 19.24px;
            line-height: 132%;
            letter-spacing: 0%;
            text-align: center;
            color: #CFD9E0;
        }

        .form-desk img {
            width: 50%;
            max-width: 1000px;
            min-width: 300px;
        }

        @media screen and (min-width: 992px) {
            .form-logo {
                position: absolute;
                top: 25px;
                left: -75px;
            }
        }

        @media screen and (max-width: 991px) {
            .form-logo {
                margin-top: 20px;
                margin-bottom: 32px;
            }

            .form-desk {
                display: none !important;
            }
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-md-center justify-content-lg-end min-height-100vh column-gap-5">
            <div class="col-md-6 col-lg-4 d-flex flex-column justify-content-center align-items-center position-relative pe-xl-5">
                <img src="{{ get_image(get_settings('logo')) }}" width="150px" alt="Logo" class="form-logo">
                <form class="auth-form" method="POST" action="{{ route('password.confirm') }}" id="ajaxForm">


                    @csrf
                    <h1 class="title text-center fs-36px mb-20px">{{ get_phrase('Confirm password') }}</h1>
                    <p class="sub-title3 text-center fs-15px mb-30px">
                        {{ get_phrase('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>

                    <div class="mb-3">
                        <label for="password" class="form-label ol2-form-label mb-3">{{ get_phrase('Password') }} <span class="form-label-required">*</span></label>
                        <div class="password-input-wrap">
                            <input type="password" class="form-control ol2-form-control password-field" id="password" name="password" placeholder="Min 8 character">
                            <div class="password-toggle-icons">
                                <span class="password-toggle-icon fs-5" toggle=".password-field">

                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.89063 12.7333C7.73229 12.7333 7.57396 12.675 7.44896 12.55C6.76562 11.8667 6.39062 10.9583 6.39062 10C6.39062 8.00834 8.00729 6.39167 9.99896 6.39167C10.9573 6.39167 11.8656 6.76667 12.549 7.45C12.6656 7.56667 12.7323 7.725 12.7323 7.89167C12.7323 8.05834 12.6656 8.21667 12.549 8.33334L8.33229 12.55C8.20729 12.675 8.04896 12.7333 7.89063 12.7333ZM9.99896 7.64167C8.69896 7.64167 7.64062 8.7 7.64062 10C7.64062 10.4167 7.74896 10.8167 7.94896 11.1667L11.1656 7.95C10.8156 7.75 10.4156 7.64167 9.99896 7.64167Z" fill="#99A1B7" />
                                        <path d="M4.66849 15.425C4.52682 15.425 4.37682 15.375 4.26016 15.275C3.36849 14.5167 2.56849 13.5833 1.88516 12.5C1.00182 11.125 1.00182 8.88333 1.88516 7.5C3.91849 4.31666 6.87682 2.48333 10.0018 2.48333C11.8352 2.48333 13.6435 3.11666 15.2268 4.30833C15.5018 4.51666 15.5602 4.90833 15.3518 5.18333C15.1435 5.45833 14.7518 5.51666 14.4768 5.30833C13.1102 4.275 11.5602 3.73333 10.0018 3.73333C7.31016 3.73333 4.73516 5.35 2.93516 8.175C2.31016 9.15 2.31016 10.85 2.93516 11.825C3.56016 12.8 4.27682 13.6417 5.06849 14.325C5.32682 14.55 5.36016 14.9417 5.13516 15.2083C5.01849 15.35 4.84349 15.425 4.66849 15.425Z" fill="#99A1B7" />
                                        <path d="M9.99818 17.5167C8.88985 17.5167 7.80651 17.2917 6.76485 16.85C6.44818 16.7167 6.29818 16.35 6.43151 16.0333C6.56485 15.7167 6.93151 15.5667 7.24818 15.7C8.13151 16.075 9.05651 16.2667 9.98985 16.2667C12.6815 16.2667 15.2565 14.65 17.0565 11.825C17.6815 10.85 17.6815 9.15 17.0565 8.175C16.7982 7.76667 16.5148 7.375 16.2148 7.00833C15.9982 6.74167 16.0398 6.35 16.3065 6.125C16.5732 5.90833 16.9648 5.94167 17.1898 6.21667C17.5148 6.61667 17.8315 7.05 18.1148 7.5C18.9982 8.875 18.9982 11.1167 18.1148 12.5C16.0815 15.6833 13.1232 17.5167 9.99818 17.5167Z" fill="#99A1B7" />
                                        <path d="M10.5737 13.5583C10.282 13.5583 10.0154 13.35 9.95702 13.05C9.89035 12.7083 10.1154 12.3833 10.457 12.325C11.3737 12.1583 12.1404 11.3917 12.307 10.475C12.3737 10.1333 12.6987 9.91666 13.0403 9.975C13.382 10.0417 13.607 10.3667 13.5404 10.7083C13.2737 12.15 12.1237 13.2917 10.6904 13.5583C10.6487 13.55 10.6153 13.5583 10.5737 13.5583Z" fill="#99A1B7" />
                                        <path d="M1.66589 18.9583C1.50755 18.9583 1.34922 18.9 1.22422 18.775C0.982552 18.5333 0.982552 18.1333 1.22422 17.8917L7.44922 11.6667C7.69089 11.425 8.09089 11.425 8.33255 11.6667C8.57422 11.9083 8.57422 12.3083 8.33255 12.55L2.10755 18.775C1.98255 18.9 1.82422 18.9583 1.66589 18.9583Z" fill="#99A1B7" />
                                        <path d="M12.1073 8.51666C11.949 8.51666 11.7906 8.45833 11.6656 8.33333C11.424 8.09166 11.424 7.69166 11.6656 7.45L17.8906 1.225C18.1323 0.98333 18.5323 0.98333 18.774 1.225C19.0156 1.46666 19.0156 1.86666 18.774 2.10833L12.549 8.33333C12.424 8.45833 12.2656 8.51666 12.1073 8.51666Z" fill="#99A1B7" />
                                    </svg>

                                </span>
                                <span class="password-toggle-icon fs-5 d-none password-toggle-icon-show" toggle=".password-field">

                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.99896 13.6083C8.00729 13.6083 6.39062 11.9917 6.39062 10C6.39062 8.00833 8.00729 6.39166 9.99896 6.39166C11.9906 6.39166 13.6073 8.00833 13.6073 10C13.6073 11.9917 11.9906 13.6083 9.99896 13.6083ZM9.99896 7.64166C8.69896 7.64166 7.64063 8.7 7.64063 10C7.64063 11.3 8.69896 12.3583 9.99896 12.3583C11.299 12.3583 12.3573 11.3 12.3573 10C12.3573 8.7 11.299 7.64166 9.99896 7.64166Z" fill="#99A1B7" />
                                        <path d="M9.99844 17.5167C6.8651 17.5167 3.90677 15.6833 1.87344 12.5C0.990104 11.125 0.990104 8.88334 1.87344 7.5C3.9151 4.31667 6.87344 2.48334 9.99844 2.48334C13.1234 2.48334 16.0818 4.31667 18.1151 7.5C18.9984 8.875 18.9984 11.1167 18.1151 12.5C16.0818 15.6833 13.1234 17.5167 9.99844 17.5167ZM9.99844 3.73334C7.30677 3.73334 4.73177 5.35 2.93177 8.175C2.30677 9.15 2.30677 10.85 2.93177 11.825C4.73177 14.65 7.30677 16.2667 9.99844 16.2667C12.6901 16.2667 15.2651 14.65 17.0651 11.825C17.6901 10.85 17.6901 9.15 17.0651 8.175C15.2651 5.35 12.6901 3.73334 9.99844 3.73334Z" fill="#99A1B7" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Confirm') }}</button>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('login') }}">{{ get_phrase('Back to login') }}</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 col-lg-6 pe-0">
                <div class="form-desk">
                    <img src="{{ asset('assets/images/login-desk.png') }}" alt="">
                    <h2 class="desk-title">{{ get_phrase('Welcome to ____', get_settings('system_name')) }}</h2>
                    <p class="desk-subtitle">{{ get_phrase('Analyzing previous trends ensures that businesses always make the right decision.') }}</p>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
@include('toastr')
