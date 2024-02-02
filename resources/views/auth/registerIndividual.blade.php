@extends('layouts.app')

@section('content')

<div class="container-fluid d-md-flex flex-md-equal">
    <!-- Left Div -->
    <div class="col-md-6 left-div">
        <!-- Your content for the left div goes here -->
        <h1 class="text-center">Left Div</h1>
    </div>

    <!-- Right Div -->
    <div class="col-md-6 right-div" style="background-color: #0A335D;">
        <div class="form-container" style="background-color: #0A335D; color: white;">
            <h1 class="text-center m-5 p-5 fw-bolder fs-1">REGISTRATION</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-1 row">
                    <label for="inputOrganizationName" class="col-sm-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select class="form-select" name="accountType" id="accountType" aria-label="Account Type" style="pointer-events: none; background-color: #f4f4f4;">
                            <option value="2">Individual</option>
                        </select>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputLastName" class="col-sm-3 col-form-label">Last Name</label>
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
                    <label for="inputFirstName" class="col-sm-3 col-form-label">First Name</label>
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
                    <label for="inputMiddleName" class="col-sm-3 col-form-label">Middle Name</label>
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
                    <label for="inputExtensionName" class="col-sm-3 col-form-label">Extension Name</label>
                    <div class="col-sm-3">
                        <input type="text" name="extensionName" class="form-control @error('extensionName') is-invalid @enderror" id="extensionName" value="{{ old('extensionName') }}" autocomplete="extensionName" autofocus>

                        @error('extensionName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputContactNumber" class="col-sm-3 col-form-label">Contact Number</label>
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
                    <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
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
                    <label for="inputOrganization" class="col-sm-3 col-form-label">Organization</label>
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
                </div>

                <div class="mb-1 row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
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
                    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
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
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
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