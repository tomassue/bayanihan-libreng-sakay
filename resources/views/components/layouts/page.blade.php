<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/cdo-seal.png') }}" rel="icon" />
    <link href="{{ asset('assets/img/cdo-seal.png') }}" rel="apple-touch-icon" />

    <!-- ANYBODY Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Anybody' rel='stylesheet'>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet" />

    <!-- SweetAlert2 -->
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BQJZKX6FYZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-BQJZKX6FYZ');
    </script>

    <style>
        .titlenav {
            font-family: Anybody !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: white;
            background-color: #0A335D;
        }

        .nav-link {
            color: #0A335D;
        }

        .btn:hover {
            color: var(--bs-btn-hover-color);
            background-color: #0A335D;
            border-color: #0A335D;
        }

        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #0A335D;
            --bs-btn-border-color: #0A335D;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #0A335D;
            --bs-btn-hover-border-color: #0A335C;
            --bs-btn-focus-shadow-rgb: 49, 132, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #0A335D;
            --bs-btn-active-border-color: #0A335D;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #0A335D;
            --bs-btn-disabled-border-color: #0A335D;
        }

        .btn-outline-primary {
            --bs-btn-color: #0A335D;
            --bs-btn-border-color: #0A335D;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #0A335D;
            --bs-btn-hover-border-color: #0A335D;
            --bs-btn-focus-shadow-rgb: 13, 110, 253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #0A335D;
            --bs-btn-active-border-color: #0A335D;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #0A335D;
            --bs-btn-disabled-bg: transparent;
            --bs-btn-disabled-border-color: #0A335D;
            --bs-gradient: none;
        }

        /* FOOTER */
        .footer {
            font-family: "Montserrat", sans-serif;
        }

        .brand-container {
            width: 100%;
            max-width: 150px;
            margin: 10px auto;
            line-height: 0;
            text-align: left;
            display: inline-block;
        }

        .link {
            background-color: #FACD06;
            margin-top: 20px;
            padding: 15px;
            border-radius: 20px;
            color: #063B47;
            box-shadow: 3px 3px #888888;
        }

        .link2 {
            background-color: #5B9EB4;
            margin-top: 20px;
            padding: 15px;
            border-radius: 20px;
            color: #F3F3EE;
            box-shadow: 3px 3px #888888;
        }

        .other-systems {
            margin-top: 12px;
            font-weight: 300 !important;
        }

        .other-systems h6 {
            color: #2F9ACB;
            font-weight: 600;
        }

        .footer-links {
            padding-left: 0;
            list-style: none;
        }

        .footer-links a {
            color: #737373;
        }

        .footer-links li {
            display: block;
        }

        .site-footer h6 {
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 5px;
            letter-spacing: 2px;
        }

        .footer-links li a {
            color: black;
            text-decoration: none;
            outline: none;
            transition: all 0.2s;
        }

        .image-block a {
            text-decoration: none;
            outline: none;
            transition: all 0.2s;
        }

        .separator {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
        }

        #myBtn {
            background: lightgray;
            display: block;
            color: #878038;
            width: 100px;
            border: none;
            border-radius: 40px;
            padding: 1px 0;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 32px;
            outline: none;
            font-size: 8pt;
        }

        .client-info {
            font-size: 11px;
            line-height: 13px;
        }

        /* END FOOTER */

        /* Tables */
        /* Center text alignment for <tr> inside <thead> */
        thead tr th {
            text-align: left;
            color: #0A335D !important;
            font-weight: bolder !important;
        }

        /* Left text alignment for <tr> inside <tbody> */
        tbody tr {
            text-align: left;
        }

        tr .item {
            background-color: #0a345e !important;
            color: white !important;
        }
    </style>
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <!-- <div class="d-flex align-items-center justify-content-between">

            <i class="bi bi-list toggle-sidebar-btn"></i>

        </div> -->
        <!-- End Logo -->

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center" wire:navigate>
                @php
                $cdo_seal = base64_encode(file_get_contents('assets/img/cdo-seal.png'));
                $bls_logo = base64_encode(file_get_contents('assets/img/bls-logo-bg2.png'));
                @endphp
                <img src="data:image/png;base64,{{ $cdo_seal }}" alt="bls-logo" />
                <img src="data:image/png;base64,{{ $bls_logo }}" alt="cdo-seal" />
                <!-- <img src={{ asset('assets/img/cdo-seal.png') }} alt="CDO SEAL"> -->
                <!-- <span id="titlenav" class="d-none d-lg-block">LIBRENG SAKAY</span> -->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <!-- <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->user_id }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->user_id }}</h6>
                            <span>{{ Auth::user()->user_id == 'ADMIN' ? 'Super Administrator' : Auth::user()->user_id }}</span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav> -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center me-5">
                @livewire('offline')
            </ul>
        </nav>

    </header>

    <livewire:navigation />

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="row"> -->
                    {{ $slot }}
                    <!-- </div> -->
                </div>
        </section>
    </main>

    <footer id="footer" class="footer" style="background-color: #fff;">
        <!-- <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <footer class="site-footer">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 mt-2">
                                        <div class="client-info">
                                            <h5>KSB Reporting System</h5>
                                            <p>
                                                This system empowers different offices and departments to efficiently input, track, and report on the number of clients served and the range of services provided during the "Klarex nga Serbisyo sa Baryo" program.
                                            </p>
                                            <p>
                                                <br />
                                                <strong>Developed by:</strong> CMISID Team /
                                                </span>
                                            </p>
                                            {{-- <p class="fw-bold pb-3">The City Planning and Development Office (CPDO)</p>
                                <p>
                                    Formulates and integrates economic, social, physical and other development objectives and policies. Prepares comprehensive plans and similar development planning documents. Monitors and evaluates the implementation of different programs, projects and activities in the city in accordance with the approved development plan.
                                </p>                     --}}
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3 col-lg-2 other-systems">
                                        <h6>other Related Systems</h6>
                                        <ul class="footer-links">

                                            <li><a href="http://119.93.152.91/dtr/" style="color: #5390ad;">Attendance Management System</a></li>

                                            <br />
                                            <li>If you have issues encountered and inquiries:<a href="https://services.cagayandeoro.gov.ph/helpdesk/" style="color: #5390ad;">
                                                    <br />
                                                    CMISID Helpdesk</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-md-3 col-lg-4 other-systems image-block">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="brand-container" style="width: fit-content;">
                                                    <img class="w-70" src="{{ asset('assets/img/cdo-seal.png') }}" style="float:left; height: 70px;">
                                                </div>
                                                <a href="https://cagayandeoro.gov.ph/" target="_blank" class='link' name='link' style="float:right;">Visit Official Website</a>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="brand-container" style="width: fit-content;">
                                                    <img src="{{ asset('assets/img/rise.png') }}" style="height: 70px;">
                                                </div>
                                                <a href="https://cagayandeoro.gov.ph/index.php/news/the-city-mayor/rise1.html" target="_blank" class='link2' name='link2' style="float:right;">Learn RISE Platform</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 separator"></div>
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-11 col-sm-6 col-xs-12">
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <img src="{{ asset('assets/img/ict-logo.png') }}">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <span style="padding-left:10px;">Powered by: City Management Information Systems and Innovation Department</span><br>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div>
                                                    <span>&nbsp;&nbsp;<div class="fb-like fb_iframe_widget" data-href="https://www.facebook.com/City-Management-Information-Systems-Office-LGU-CdeO-568493593557935/" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true" data-show-faces="false"></div></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-6 col-xs-12 version">
                                            Version 1.0
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12">
                    <footer class="site-footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-2">
                                    <div class="client-info">
                                        <h5>Bayanihan Libreng Sakay System</h5>
                                        <p>
                                            This system designed and developed for volunteer riders and organization for their libreng sakay program.
                                        </p>
                                        <p>
                                            <br />
                                            <strong>Developed by:</strong> CMISID Team /
                                            </span>
                                        </p>
                                        {{-- <p class="fw-bold pb-3">The City Planning and Development Office (CPDO)</p>
                                <p>
                                    Formulates and integrates economic, social, physical and other development objectives and policies. Prepares comprehensive plans and similar development planning documents. Monitors and evaluates the implementation of different programs, projects and activities in the city in accordance with the approved development plan.
                                </p>                     --}}
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 col-lg-2 other-systems">
                                    <!-- <h6>other Related Systems</h6> -->
                                    <ul class="footer-links">
                                        <!-- <li><a href="http://119.93.152.91/dtr/" style="color: #5390ad;">Attendance Management System</a></li> -->
                                        <br />
                                        <li>If you have issues encountered and inquiries:<a href="https://services.cagayandeoro.gov.ph/helpdesk/" style="color: #5390ad;">
                                                <br />
                                                CMISID Helpdesk</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-6 col-md-3 col-lg-4 other-systems">
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <div class="brand-container" style="width: fit-content;">
                                                <img src="{{ asset('assets/img/cdofull.png') }}" style="float:left; height: 50px;">
                                            </div>
                                            <a href="https://cagayandeoro.gov.ph/" target="_blank" class='link' name='link' style="float:right; margin-top: 0px;">Visit Official Website</a>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <div class="brand-container" style="width: fit-content;">
                                                <img src="{{ asset('assets/img/rise.png') }}" style="height: 70px;">
                                            </div>
                                            <a href="https://cagayandeoro.gov.ph/index.php/news/the-city-mayor/rise1.html" target="_blank" class='link2' name='link2' style="float:right;">Learn RISE Platform</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 separator"></div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-11 col-sm-6 col-xs-12">
                                        <div class="d-flex justify-content-center">
                                            <div>
                                                <img src="{{ asset('assets/img/ict-logo.png') }}">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div>
                                                <span>Powered by: City Management Information Systems and Innovation Department</span><br>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <div>
                                                <span>&nbsp;&nbsp;<div class="fb-like fb_iframe_widget" data-href="https://www.facebook.com/City-Management-Information-Systems-Office-LGU-CdeO-568493593557935/" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true" data-show-faces="false"></div></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-6 col-xs-12 version">
                                        Version 1.0
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </footer>

    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_LA/sdk.js#xfbml=1&version=v14.0" nonce="wcxFHnry"></script>
    <script>
        function toggleFooter() {
            var dots = document.getElementById("dots");
            var more = document.getElementById("more");
            var myBtn = document.getElementById("myBtn");
            if (more.style.display === "none") {
                more.style.display = "block";
                myBtn.textContent = "Read Less";
                dots.style.display = "none";
            } else {
                more.style.display = "none";
                myBtn.textContent = "Read More";
                dots.style.display = "block";
            }
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('something-went-wrong', (event) => {
                Swal.fire({
                    title: "Something went wrong!",
                    text: "Please try again.",
                    icon: "error"
                });
            });
        });
    </script>

</body>

</html>