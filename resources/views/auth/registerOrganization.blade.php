@extends('layouts.app')

@section('content')

<style>
    /* Footer */
    #footer {
        /* color: #426FE0; */
        font-size: xx-small;
        /* color: black; */
        -webkit-text-fill-color: white;
        /* Will override color (regardless of order) */
        -webkit-text-stroke: 0.2px black;
    }

    /* Left Div */
    .left-div {
        background-image: url("{{ asset('assets/img/Group 2.png') }}"),
        url("{{ asset('assets/img/Group 8.png') }}");
        background-repeat: no-repeat, no-repeat;
        /* background-size: contain, contain; */
        background-size: 80%, 80%;
        background-position: center top, left bottom;
        height: 1082px !important;
    }

    /* Right Div */
    .right-div {
        background-image: url("{{ asset('assets/img/Polygon 6.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
        /* background-position: center; */
        height: 100%;
    }

    /* Ensure equal heights for right and left divs */
    .container-fluid {
        display: flex;
    }

    /* Adjust column widths for equal heights */
    .col-md-6 {
        flex: 1;
    }

    @media screen and (max-width: 425px) {
        .left-div {
            display: none;
        }

        .right-div {
            height: 1170px !important;
        }

        #footer {
            margin-top: 100px;
        }
    }

    @media screen and (max-width: 768px) {
        .left-div {
            background-image: url("{{ asset('assets/img/Group 2.png') }}"),
            url("{{ asset('assets/img/Group 8.png') }}");
            background-repeat: no-repeat, no-repeat;
            /* background-size: contain, contain; */
            background-size: 110%, 200%;
            background-position: center top, left 400px;
            height: 100%;
        }

        .form-container {
            height: 946px !important;
        }
    }

    @media screen and (min-width: 1024px) and (max-width: 2560px) {
        .form-container {
            height: 1000px !important;
        }
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: 0px;padding-right: 0px; height: fit-content;">
    <!-- Left Div -->
    <div class="col-md-6 left-div vh-100" style="height: 1000px;">
        <div class="col">

        </div>
    </div>

    <!-- Right Div -->
    <div class="col-md-6 right-div">
        <div class="form-container" style="color: white; color: white; background-color: unset;">
            <h1 class="text-center fw-bolder fs-1 py-5 mt-5">REGISTRATION</h1>

            <form method="POST" id="registrationForm" action="{{ route('register') }}">
                @csrf

                <!-- Account Type -->
                <div class="mb-1 row">
                    <label for="accnt_type" class="col-sm-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select class="form-select" name="accountType" id="accountType" aria-label="Account Type" style="pointer-events: none; background-color: #f4f4f4;">
                            <option value="1">Organization</option>
                        </select>
                    </div>
                </div>

                <!-- Organization Name -->
                <div class="mb-1 row">
                    <label for="organizationName" class="col-sm-3 col-form-label">Organization Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="organizationName" class="form-control @error('organizationName') is-invalid @enderror" id="organizationName" value="{{ old('organizationName') }}" autocomplete="organizationName" autofocus>

                        @error('organizationName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Date Established -->
                <div class="mb-1 row">
                    <label for="dateEstablished" class="col-sm-3 col-form-label">Date Established</label>
                    <div class="col-sm-5">
                        <input type="date" name="dateEstablished" class="form-control @error('dateEstablished') is-invalid @enderror" id="dateEstablished" value="{{ old('dateEstablished') }}" autocomplete="dateEstablished" autofocus>

                        @error('dateEstablished')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-1 row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="address" class="form-control @error('dateEstablished') is-invalid @enderror" id="address" value="{{ old('address') }}" autocomplete="address" autofocus>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="mb-1 row">
                    <label for="contactNumber" class="col-sm-3 col-form-label">Contact Number</label>
                    <div class="col-sm-7">
                        <input type="text" name="contactNumber" class="form-control @error('contactNumber') is-invalid @enderror" id="contactNumber" value="{{ old('contactNumber') }}" autocomplete="contactNumber" autofocus>

                        @error('contactNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-1 row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-1 row">
                    <label for="password" class="col-sm-3 col-form-label">Password
                        <div class="hover-text">
                            <i class="ps-2 bi bi-info-circle"></i>
                            <span class="tooltip-text" id="right">The password must have at least 8 characters, contain both letters, numbers, and special characters.</span>
                        </div>
                    </label>
                    <div class="col-sm-7">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-1 row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <!-- Triggers Privacy Modal -->
                <div class="text-center pt-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dataPrivacyModal">REGISTER</button>
                </div>

                <!-- Submit Button -->
                @include('data-privacy-modal')

            </form>
        </div>
        <div class="pt-4 pb-3 text-center" id="footer">
            <img src="{{ asset('assets/img/ict-logo.png') }}" alt="ICT LOGO">&nbsp;&nbsp;POWERED BY: CITY MANAGEMENT INFORMATION SYSTEMS AND INNOVATION DEPARTMENT
        </div>
    </div>
</div>

<script>
    // JavaScript to prevent user interaction
    document.addEventListener("DOMContentLoaded", function() {
        var readonlySelect = document.getElementById("accountType"); // Replace "yourSelectId" with the actual ID of your select element
        readonlySelect.addEventListener("mousedown", function(event) {
            event.preventDefault();
        });
    });
</script>

@endsection