<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

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

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

    <style>
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
    </style>
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">

            <i class="bi bi-list toggle-sidebar-btn"></i>

        </div>
        <!-- End Logo -->

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

    </header>

    <aside id="sidebar" class="sidebar" style="background-color: #0A335D; padding-right: unset;">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed fs-5" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#" aria-expanded="false" style="border-radius: unset;">
                    <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle me-2" style="height: 50px; width: 50px;">
                    <span class="text-truncate col-9">
                        {{ Auth::user()->user_id == 'ADMIN' ? 'Administrator' : Auth::user()->organization_information->organization_name }}
                    </span>
                </a>
                <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li class="nav-item">
                        <a class="align-items-center fs-5" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();" style="color: white;">
                            <span>> &nbsp; Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>

            <hr style="color: #FFFFFF; margin-right: 20px;">

            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="/dashboard" style="border-radius: unset;">
                    <span class="fs-5 fw-bold">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('registration') ? '' : 'collapsed' }}" href="/registration" style="border-radius: unset;">
                    <span class="fs-5 fw-bold">Registration</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('events') ? '' : 'collapsed' }}" href="/events" style="border-radius: unset;">
                    <span class="fs-5 fw-bold">Events</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('reports') ? '' : 'collapsed' }}" href="#" style="border-radius: unset;">
                    <span class="fs-5 fw-bold">Reports</span>
                </a>
            </li>
        </ul>
    </aside>

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

    <footer id="footer" class="footer">
        <div class="copyright">
            <img src="{{ asset('assets/img/ict-logo.png') }}" alt="ICT LOGO">&nbsp;&nbsp;POWERED BY: CITY MANAGEMENT INFORMATION SYSTEMS AND INNOVATION DEPARTMENT
        </div>
        <!-- <div class="credits">
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div> -->
    </footer>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- You need this to perform scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>