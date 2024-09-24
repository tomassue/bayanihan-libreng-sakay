@extends('layouts.app')

@section('content')

<style>
    /* LEFT DIV */
    @media screen and (max-width: 767px) {
        div.left {
            display: none;
        }
    }

    /* RIGHT DIV */
    .small-image {
        height: 185px;
        width: 180px;
    }

    .medium-image {
        height: 135px;
        width: 250px;
    }

    @media screen and (max-width: 1440px) {
        .small-image {
            height: 185px;
            width: 180px;
        }

        .medium-image {
            height: 135px;
            width: 250px;
        }
    }

    @media screen and (max-width: 1024px) {
        .small-image {
            height: 100px;
            width: 100px;
        }

        .medium-image {
            height: 100px;
            width: 180px;
        }

        .logo {
            padding-left: unset !important;
        }
    }

    @media screen and (max-width: 768px) {
        .small-image {
            height: 80px;
            width: 80px;
        }

        .medium-image {
            height: 80px;
            width: 160px;
        }

        .right {
            padding-left: unset !important;
            padding-right: unset !important;
        }
    }

    @media screen and (max-width: 320px) {
        .small-image {
            height: 70px;
            width: 70px;
        }

        .medium-image {
            height: 60px;
            width: 120px;
        }

        .right {
            padding-left: unset !important;
            padding-right: unset !important;
        }
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: var(--bs-gutter-x,.0);padding-right: var(--bs-gutter-x,.0);">
    <!-- Left Div -->
    <div class="left col-md-7 left-div vh-100" style="height: 1000px;">
        <div class="col" style="height: 98px;">

        </div>
        <div class="col px-5 pb-4">
            <img src="assets/img/copy2.png" alt="logo" style="max-height: 100%; max-width: 100%; padding-left: 80px;" class="logo">
        </div>
        <div class="col py-auto pb-4" style="height: 100px; text-align:center;">
            <img src="assets/img/pickmeup.png" alt="logo" style="height: 100px; width: 100px;">
            <img src="assets/img/Fetch_CDO_Official_Logo.png" alt="logo" style="height: 100px; width: 100px;">
            <img src="assets/img/fetch.png" alt="logo" style="height: 100px; width: 100px;">
            <img src="assets/img/fastpickup.png" alt="logo" style="height: 100px; width: 100px;">
            <img src="assets/img/dispatch.png" alt="logo" style="height: 100px; width: 100px;">
        </div>
        <div class="col pt-5 mt-5">
            <img src="assets/img/copy.png" alt="triangles" style="max-height: 100%; max-width: 100%;">
        </div>
    </div>

    <!-- Right Div -->
    <div class="col-md-5 right-div vh-100" style="background-color: #FFFF;">
        <div class="form-container" style="background-color: #FFFF; color: white;">

            <div class="mt-5 mb-5 py-5 px-5 text-center right" style="display: block; width: auto;">
                <img src="{{ asset('assets/img/cdo-seal.png') }}" alt="cdo-seal" class="small-image">
                <img src="{{ asset('assets/img/rise.png') }}" alt="cdo-seal" class="medium-image">
            </div>

            @if(session('status'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 400px;">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                <!-- You need @csrf when using POST as the form method -->
                @csrf

                <div class="mb-1 row">
                    <div class="d-flex justify-content-center mb-2">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="USERNAME" aria-label="default input example" style="width: 400px; text-align: center;" required autocomplete="email" autofocus>
                    </div>

                    <div class="d-flex justify-content-center mb-2">
                        @error('email')
                        <span class="badge border-danger border-1 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required automcomplete="current-password" placeholder="PASSWORD" aria-label="default input example" style="width: 400px; text-align: center;">
                    </div>

                    <div class="d-flex justify-content-center mb-2">
                        @error('password')
                        <span class="badge border-danger border-1 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center pt-3">
                    <button type="submit" class="btn btn-primary fs-w" style="width: 350px;"><b>LOGIN</b></button>
                </div>

                <div class="d-flex justify-content-center text-center pt-4">
                    <a href="{{ route('register') }}" style="text-decoration:none"><span style="color: #426FE0;">Not yet registered?</span></a>
                </div>

            </form>

            <div class="pt-5 mt-5 text-center" style="color: #426FE0; font-size:x-small;" id="footer">
                <img src="{{ asset('assets/img/ict-logo.png') }}" alt="ICT LOGO">&nbsp;&nbsp;POWERED BY: CITY MANAGEMENT INFORMATION SYSTEMS AND INNOVATION DEPARTMENT
            </div>

        </div>
    </div>
</div>

@endsection