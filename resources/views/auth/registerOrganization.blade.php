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

                <!-- Account Type -->
                <div class="mb-1 row">
                    <label for="accnt_type" class="col-sm-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select class="form-select" name="accnt_type" aria-label="Account Type" disabled>
                            <option value="1" selected>Organization</option>
                        </select>
                    </div>
                </div>

                <!-- Organization Name -->
                <div class="mb-1 row">
                    <label for="organizationName" class="col-sm-3 col-form-label">Organization Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="organizationName" class="form-control" id="organizationName" value="{{ old('organizationName') }}" required autocomplete="organizationName" autofocus>

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
                        <input type="date" name="date" class="form-control" id="dateEstablished">
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-1 row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                </div>

                <!-- Contact Number -->
                <div class="mb-1 row">
                    <label for="contactNumber" class="col-sm-3 col-form-label">Contact Number</label>
                    <div class="col-sm-7">
                        <input type="text" name="contactNumber" class="form-control" id="contactNumber">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-1 row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-1 row">
                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-1 row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-2">
                    <button type="submit" class="btn btn-primary">REGISTER</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection