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

        .wew {
            height: 800px !important;
        }
    }

    @media screen and (min-width: 1024px) and (max-width: 2560px) {
        .wew {
            height: 800px !important;
        }
    }
</style>

<div class="container-fluid d-md-flex flex-md-equal" style="padding-left: 0px;padding-right: 0px; height: fit-content;">
    <!-- Left Div -->
    <div class="col-md-6 left-div" style="height: 800px;">
        <div class="col" style="height: 98px;">

        </div>
    </div>

    <!-- Right Div -->
    <div class="col-md-6 right-div" style="height: 100%;">
        <div class="form-container wew" style="color: white; background-color: unset;">
            <h1 class="text-center fw-bolder fs-1 py-5 mt-5">REGISTRATION</h1>
            <form method="POST" action="{{ route('registration') }}">
                <!-- You need @csrf when using POST as the form method -->
                @csrf

                <div class="mb-1 row">
                    <label for="inputAccountType" class="col-lg-4 col-xl-3 col-md-4 col-form-label">Account Type</label>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-9">
                        <select name="accountType" id="accountType" class="form-select" aria-label="Default select example" required>
                            <option value="" selected disabled>Select...</option>
                            @foreach(\App\Models\AccountTypeModel::all() as $accountType)
                            <option value="{{ $accountType['id'] }}">{{ $accountType['account_type_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-center pt-4">
                        <button type="submit" class="btn btn-primary">PROCEED</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection