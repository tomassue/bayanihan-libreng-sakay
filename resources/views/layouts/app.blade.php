<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bayanihan Libreng Sakay') }}</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.bunny.net"> -->
    <!-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->

    <link href='https://fonts.googleapis.com/css?family=Anybody' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

    <!-- Icons -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />

    <!-- GOOGLE RECAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        // function onSubmit(token) {
        //     document.getElementById("registrationForm").submit();
        // }

        function onSubmit(token) {
            var form = document.getElementById("registrationForm");
            if (form.checkValidity()) {
                document.getElementById("registrationForm").submit();
            } else {
                form.reportValidity();
            }
        }
    </script>

    <title>Registration Form</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Anybody';
        }

        .container-fluid {
            height: 100%;
        }

        .left-div,
        .right-div {
            height: 100%;
        }

        .form-container {
            padding: 20px;
            background-color: #f8f9fa;
        }

        label {
            font-weight: bolder;
        }

        button {
            width: 250px;
            background-image: linear-gradient(#00BF63, #0A335D);
            border-style: solid;
            border-color: #A8A6A6 !important;
        }

        /* TOOL TIP */

        .tooltip-text {
            visibility: hidden;
            position: absolute;
            z-index: 2;
            width: 150px !important;
            color: white;
            font-size: 12px;
            background-color: #192733;
            border-radius: 10px;
            padding: 10px 15px 10px 15px;
        }

        .tooltip-text::before {
            content: "";
            position: absolute;
            transform: rotate(45deg);
            background-color: #192733;
            padding: 5px;
            z-index: 1;
        }

        .hover-text:hover .tooltip-text {
            visibility: visible;
        }

        #top {
            top: -40px;
            left: -50%;
        }

        #top::before {
            top: 80%;
            left: 45%;
        }

        #bottom {
            top: 25px;
            left: -50%;
        }

        #bottom::before {
            top: -5%;
            left: 45%;
        }

        #left {
            top: -8px;
            right: 120%;
        }

        #left::before {
            top: 35%;
            left: 94%;
        }

        #right {
            top: -8px;
            left: 120%;
        }

        #right::before {
            top: 35%;
            left: -2%;
        }

        .hover-text {
            position: relative;
            display: inline-block;
            margin: unset;
        }

        /* END TOOL TIP */
    </style>

</head>

<body>

    <!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Bayanihan Libreng Sakay') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">

                </ul>

                <ul class="navbar-nav ms-auto">

                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav> -->

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>