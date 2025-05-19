
<!DOCTYPE html>
<html lang="en" class="default">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{get_phrase('Forgot Password')}} | {{get_settings('system_title')}}</title>
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
            background-image: url('{{ asset("assets/images/login-desk-shape.png") }}');
            background-size: 65%;
            background-repeat: no-repeat;
            background-position-x: right;
        }
        .form-desk .desk-title{
            font-family: Inter;
            font-weight: 600;
            font-size: 38.48px;
            line-height: 100%;
            letter-spacing: 0%;
            color: #F7FAFC;
            margin: 32px 0px;
        }
        .form-desk .desk-subtitle{
            font-family: Inter;
            font-weight: 400;
            font-size: 19.24px;
            line-height: 132%;
            letter-spacing: 0%;
            text-align: center;
            color: #CFD9E0;
        }
        .form-desk img{
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
            .form-desk{
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
                <form class="auth-form" method="POST" action="{{ route('password.email') }}" id="ajaxForm">


                    @csrf
                    <h1 class="title text-center fs-36px mb-20px">{{ get_phrase('Forgot password') }}</h1>
                    <p class="sub-title3 text-center fs-15px mb-30px">
                        {{ get_phrase('Lost your password? Please enter your email address. You will receive a link to create a new password via email.') }}
                    </p>
                    <div class="mb-20px">
                        <label for="email" class="form-label ol2-form-label mb-3">{{ get_phrase('Email') }} <span class="form-label-required">*</span></label>
                        <input type="email" class="form-control ol2-form-control" id="email" name="email" placeholder="Your email here">
                    </div>
                    
                    <button type="submit" class="btn ol2-btn-primary w-100 mb-3">{{ get_phrase('Reset Password') }}</button>
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
                    <h2 class="desk-title">{{get_phrase('Welcome to ____', get_settings('system_name'))}}</h2>
                    <p class="desk-subtitle">{{get_phrase('Analyzing previous trends ensures that businesses always make the right decision.')}}</p>
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
