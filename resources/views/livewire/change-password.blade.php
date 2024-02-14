<div>
    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="col">
        <div class="card border border-secondary">
            <div class="row mx-4 mt-4">
                <div class="col">
                    <div class="card border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class="container">

                                <div class="card mt-4" style="box-shadow: unset;">
                                    <div class="card-body" style="background-color: #ffffff;">
                                        <h5 class="card-title fw-bolder">Change Password</h5>

                                        <form wire:submit="changePass('{{ Auth::user()->id }}')" data-bitwarden-watching="1">

                                            <div class="row mb-3">
                                                <label for="inputCurrentPassword" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Current Password</label>
                                                <div class="col-sm-12 col-md-8 col-lg-9">
                                                    <input type="password" class="form-control @error('currentPass') is-invalid @enderror" value="{{ old('currentPass') }}" wire:model.blur="currentPass">
                                                    @error('currentPass')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputPassword" class="col-sm-12 col-md-4 col-lg-3 col-form-label">New Password<i class="ps-2 bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="The password must have at least 8 characters, contain both letters, numbers, and special characters."></i></label>

                                                <div class="col-sm-12 col-md-8 col-lg-9">
                                                    <input type="password" class="form-control @error('newPass') is-invalid @enderror" wire:model.blur="newPass">
                                                    @error('newPass')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="inputConfirmPassword" class="col-sm-12 col-md-4 col-lg-3 col-form-label">Confirm Password</label>
                                                <div class="col-sm-12 col-md-8 col-lg-9">
                                                    <input type="password" class="form-control @error('confirmPass') is-invalid @enderror" wire:model.blur="confirmPass">
                                                    @error('confirmPass')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row justify-content-end">
                                                <div class="col-auto">
                                                    <button type="submit" class="btn fw-bolder mt-2" style="background-color: #2e8b57; color:#FFFFFF;">Save Changes</button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>