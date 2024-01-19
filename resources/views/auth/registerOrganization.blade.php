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
                            <option value="1" selected>Organization</option>
                        </select>
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputOrganizationName" class="col-sm-3 col-form-label">Organization Name</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="organizationName">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputDateEstablished" class="col-sm-3 col-form-label">Date Established</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" id="dateEstablished">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputAddress" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="address">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputContactNumber" class="col-sm-3 col-form-label">Contact Number</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="contactNumber">
                    </div>
                </div>

                <div class="mb-1 row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" id="email">
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