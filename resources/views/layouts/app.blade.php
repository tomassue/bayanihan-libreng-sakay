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
    </style>

</head>

<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>