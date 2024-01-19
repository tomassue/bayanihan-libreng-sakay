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
                        <select class="form-select" aria-label="Default select example" disabled>
                            <option value="2" selected>Individual</option>
                        </select>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label for="inputLastName" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="lastName">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputFirstName" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="firstName">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputMiddleName" class="col-sm-3 col-form-label">Middle Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="middleName">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputExtensionName" class="col-sm-3 col-form-label">Extension Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="extensionName">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputContactNumber" class="col-sm-3 col-form-label">Contact Number</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="contactNumber">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="address">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputOrganization" class="col-sm-3 col-form-label">Organization</label>
                    <div class="col-sm-7">
                        <select name="organization" id="organization" class="form-select" aria-label="Default select example">
                            <option selected disabled>Select...</option>
                            @foreach(\App\Models\OrganizationInformationModel::all() as $organization)
                            <option value="{{ $organization['id'] }}">{{ $organization['account_type_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="email">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" id="password">
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