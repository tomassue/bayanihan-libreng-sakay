@extends('layouts.app')

@section('content')

<style>
    .right-div {
        background-image: url("{{ asset('assets/img/Polygon 3.png') }}");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 100%;
        /* background-attachment: fixed; */
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: 0px;padding-right: 0px;">
    <!-- Left Div -->
    <div class="col-md-6 left-div">
        <!-- Your content for the left div goes here -->
        <h1 class="text-center">Left Div</h1>
    </div>

    <!-- Right Div -->
    <div class="col-md-6 right-div">
        <div class="form-container" style="color: white; background-color: unset;">
            <h1 class="text-center m-5 p-5 fw-bolder fs-1">REGISTRATION</h1>
            <form method="POST" action="{{ route('registration') }}">
                <!-- You need @csrf when using POST as the form method -->
                @csrf

                <div class="mb-1 row">
                    <label for="inputAccountType" class="col-sm-3 col-form-label">Account Type</label>
                    <div class="col-sm-7">
                        <select name="accountType" id="accountType" class="form-select" aria-label="Default select example" required>
                            <option value="" selected disabled>Select...</option>
                            @foreach(\App\Models\AccountTypeModel::all() as $accountType)
                            <option value="{{ $accountType['id'] }}">{{ $accountType['account_type_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-center pt-2">
                    <button type="submit" class="btn btn-primary">PROCEED</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection