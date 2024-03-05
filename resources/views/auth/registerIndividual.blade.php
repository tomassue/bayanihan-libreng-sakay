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

    .wew {
        height: 917px !important;
    }

    /* Left Div */
    .left-div {
        background-image: url("{{ asset('assets/img/Group 2.png') }}"),
        url("{{ asset('assets/img/Group 8.png') }}");
        background-repeat: no-repeat, no-repeat;
        /* background-size: contain, contain; */
        background-size: 80%, 80%;
        background-position: center top, left bottom;
        height: 1000px !important;
    }

    /* Right Div */
    .right-div {
        background-image: url("{{ asset('assets/img/Polygon 6.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
        /* background-position: center; */
        height: 1000px !important;
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
            height: 1490px !important;
        }

        #footer {
            margin-top: 80px;
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
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: 0px;padding-right: 0px; height: fit-content;">

    <div class="col-md-6 left-div vh-100">
        <div class="col">

        </div>
    </div>

    <div class="col-md-6 right-div">
        <div class="form-container" style="background-color: unset; color: white;">
            <h1 class="text-center fw-bolder fs-1 py-5 mt-5">REGISTRATION</h1>

            <form method="POST" id="registrationForm" action="{{ route('register') }}">
                @csrf

                <div class="mb-1 row">
                    <label for="inputOrganizationName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select class="form-select" name="accountType" id="accountType" aria-label="Account Type" style="pointer-events: none; background-color: #f4f4f4;">
                            <option value="2">Rider</option>
                        </select>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputLastName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Last Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="lastName" class="form-control @error('lastName') is-invalid @enderror" id="lastName" value="{{ old('lastName') }}" autocomplete="lastName" autofocus>

                        @error('lastName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputFirstName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">First Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="firstName" value="{{ old('firstName') }}" autocomplete="firstName" autofocus>

                        @error('firstName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputMiddleName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Middle Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="middleName" class="form-control @error('middleName') is-invalid @enderror" id="middleName" value="{{ old('middleName') }}" autocomplete="middleName" autofocus>

                        @error('middleName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputExtensionName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Extension Name</label>
                    <div class="col-sm-3 col-lg-5">
                        <input type="text" name="extensionName" class="form-control @error('extensionName') is-invalid @enderror" id="extensionName" value="{{ old('extensionName') }}" autocomplete="extensionName" autofocus>

                        @error('extensionName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputContactNumber" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Contact Number</label>
                    <div class="col-sm-7">
                        <input type="text" name="contactNumber" class="form-control @error('contactNumber') is-invalid @enderror" id="contactNumber" value="{{ old('contactNumber') }}" autocomplete="contactNumber" autofocus>

                        @error('contactNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputAddress" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address') }}" autocomplete="address" autofocus>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- <div class="mb-1 row">
                    <label for="inputOrganization" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Organization</label>
                    <div class="col-sm-7">
                        <select name="organization" id="organization" class="form-select @error('organization') is-invalid @enderror" value="{{ old('organization') }}" autocomplete="organization" autofocus aria-label="Default select example">
                            <option selected disabled>Select...</option>
                            @foreach(\App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                            ->where('users.status', 1)
                            ->select('organization_information.id AS org_id', 'organization_information.*')
                            ->get() as $organization)
                            <option value="{{ $organization['org_id'] }}">{{ $organization['organization_name'] }}</option>
                            @endforeach
                        </select>

                        @error('organization')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div> -->
                <!-- As you can notice, the code below is slightly different from above. Those conditions below will retain the value selected after submitting then an error occurred.-->
                <div class="mb-1 row">
                    <label for="inputOrganization" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Organization</label>
                    <div class="col-sm-7">
                        <select name="organization" id="organization" class="form-select @error('organization') is-invalid @enderror" autocomplete="organization" autofocus aria-label="Default select example">
                            <option value="" disabled {{ old('organization') ? '' : 'selected' }}>Select...</option>
                            @foreach(\App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                            ->where('users.status', 1)
                            ->select('organization_information.id AS org_id', 'organization_information.*')
                            ->get() as $organization)
                            <option value="{{ $organization['org_id'] }}" {{ old('organization') == $organization['org_id'] ? 'selected' : '' }}>{{ $organization['organization_name'] }}</option>
                            @endforeach
                        </select>

                        @error('organization')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputEmail" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputPassword" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Password
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

                <div class="mb-1 row">
                    <label for="password_confirmation" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <div class="text-center pt-2">
                    <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dataPrivacyModal">REGISTER</button>
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

@endsection