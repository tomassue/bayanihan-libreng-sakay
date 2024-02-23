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
            <h1 class="text-center fw-bolder fs-1 py-5 mt-5">THANK YOU FOR REGISTERING</h1>

            <div class="text-center pt-2">
                <a href="{{ route('get-my-qr', $ClientUserID) }}" target="_blank">
                    <button type="button" class="btn btn-primary">GET MY QR</button>
                </a>
            </div>

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