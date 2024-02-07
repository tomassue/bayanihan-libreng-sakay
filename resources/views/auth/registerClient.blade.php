@extends('layouts.app')

@section('content')

<style>
    /* Left Div */
    .left-div {
        background-image: url("{{ asset('assets/img/Group 2.png') }}"),
        url("{{ asset('assets/img/Group 8.png') }}");
        background-repeat: no-repeat, no-repeat;
        /* background-size: contain, contain; */
        background-size: 80%, 80%;
        background-position: center top, left bottom;
        height: 100%;
    }

    /* Right Div */
    .right-div {
        background-image: url("{{ asset('assets/img/Polygon 6.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
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

    @media screen and (max-width: 430px) {
        .left-div {
            display: none;
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

    @media screen and (max-width: 1024px) {
        .left-div {
            background-image: url("{{ asset('assets/img/Group 2.png') }}"),
            url("{{ asset('assets/img/Group 8.png') }}");
            background-repeat: no-repeat, no-repeat;
            /* background-size: contain, contain; */
            background-size: 95%, 180%;
            background-position: center top, left bottom;
            height: 100%;
        }
    }

    @media screen and (min-width: 1024px) and (max-width: 2560px) {
        .wews {
            height: 914px !important;
        }
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: 0px; padding-right: 0px; height: fit-content;">

    <div class="col-md-6 left-div wews" style="height: 800px;">
        <div class="col">

        </div>
    </div>

    <div class="col-md-6 right-div" style="height: 100%;">
        <div class="form-container" style="background-color: unset; color: white;">
            <h1 class="text-center fw-bolder fs-1 py-5 mt-5">REGISTRATION</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-1 row">
                    <label for="inputOrganizationName" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select class="form-select" name="accountType" id="accountType" aria-label="Account Type" style="pointer-events: none; background-color: #f4f4f4;">
                            <option value="3" selected>Client</option>
                        </select>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputUserType" class="col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">User Type</label>
                    <div class="col-sm-7">
                        <select name="userType" id="userType" class="form-select @error('userType') is-invalid @enderror" value="{{ old('userType') }}" autocomplete="userType" autofocus aria-label="Default select example">
                            <option selected disabled>Select...</option>
                            <option value="student">Student</option>
                            <option value="staff">Staff</option>
                            <option value="other">Other</option>
                        </select>

                        @error('userType')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputLastName" class="col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Last Name</label>
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
                    <label for="inputFirstName" class="col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">First Name</label>
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
                    <label for="inputMiddleName" class="col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Middle Name</label>
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
                    <label for="inputExtensionName" class="col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Extension Name</label>
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
                    <label for="labelforBirthday" class="col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Birthday</label>
                    <div class="col-sm-3 col-lg-5">
                        <input type="date" name="birthday" class="form-control @error('birthday') is-invalid @enderror" id="birthday" value="{{ old('birthday') }}" autocomplete="birthday" autofocus>

                        @error('birthday')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputContactNumber" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Contact Number</label>
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
                    <label for="inputAddress" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address') }}" autocomplete="address" autofocus>

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputSchool" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">School</label>
                    <div class="col-sm-7">
                        <select name="school" id="school" class="form-select @error('school') is-invalid @enderror" value="{{ old('school') }}" autocomplete="school" autofocus aria-label="Default select example">
                            <option selected disabled>Select...</option>
                            @foreach(\App\Models\SchoolInformationModel::all() as $school)
                            <option value="{{ $school['id'] }}">{{ $school['school_name'] }}</option>
                            @endforeach
                        </select>

                        @error('school')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputGuardiansName" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label" style="font-size: small;">In case of emergency</label>
                    <div class="col-sm-7">
                        <input type="text" name="guardianName" class="form-control @error('guardianName') is-invalid @enderror" id="guardianName" value="{{ old('guardianName') }}" autocomplete="address" autofocus>

                        @error('guardianName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputGuardiansNumber" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label" style="font-size: small;">Emergency contact no.</label>
                    <div class="col-sm-7">
                        <input type="text" name="guardianNumber" class="form-control @error('guardianNumber') is-invalid @enderror" id="guardianNumber" value="{{ old('guardianNumber') }}" autocomplete="address" autofocus>

                        @error('guardianNumber')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputEmail" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Email</label>
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
                    <label for="inputPassword" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Password</label>
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
                    <label for="password_confirmation" class="col-sm-3 col-sm-3 col-sm-3 col-md-4 col-lg-4 col-xl-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                    </div>
                </div>

                <div class="text-center pt-2">
                    <button type="submit" class="btn btn-primary">REGISTER</button>
                </div>
            </form>
        </div>
    </div>

</div>


@endsection