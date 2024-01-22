@extends('layouts.app')

@section('content')

<div class="container-fluid d-md-flex flex-md-equal">
    <!-- Left Div -->
    <div class="col-md-6 left-div">
        <!-- Your content for the left div goes here -->
        <h1 class="text-center">Left Div</h1>
    </div>

    <!-- Right Div -->
    <div class="col-md-6 right-div" style="background-color: #FFFF;">
        <div class="form-container" style="background-color: #FFFF; color: white;">

            <div class="mt-5 mb-5 py-5 px-5 text-center" style="display: block; width: auto;">
                <img src="{{ asset('assets/img/cdo-seal.png') }}" alt="cdo-seal" style="height: 185px; width: 180px;">
                <img src="{{ asset('assets/img/rise.png') }}" alt="cdo-seal" style="height: 135px; width: 250px;">
            </div>

            <form method="POST" action="{{ route('login') }}">
                <!-- You need @csrf when using POST as the form method -->
                @csrf


                <div class="mb-1 row">
                    <div class="d-flex justify-content-center mb-2">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="USERNAME" aria-label="default input example" style="width: 400px; text-align: center;" required autocomplete="email" autofocus>
                    </div>

                    <div class="d-flex justify-content-center mb-2">
                        @error('email')
                        <span class="badge border-danger border-1 text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required automcomplete="current-password" placeholder="PASSWORD" aria-label="default input example" style="width: 400px; text-align: center;">
                    </div>

                    <div class="d-flex justify-content-center mb-2">
                        @error('password')
                        <span class="badge border-danger border-1 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center pt-3">
                    <button type="submit" class="btn btn-primary fs-w" style="width: 350px;"><b>LOGIN</b></button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection