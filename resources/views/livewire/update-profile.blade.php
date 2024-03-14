<div>
    <div class="pagetitle">
        <h1>Profile</h1>
    </div>

    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset('assets/img/profile.png') }}" alt="Profile" class="rounded-circle">
                        <h2>{{Auth::user()->organization_information->organization_name}}</h2>
                        <h3>{{Auth::user()->user_id == 'ADMIN' ? 'Administrator' : 'Organization'}}</h3>
                        <!-- <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> -->
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($page_one) active @endif" wire:click="pageOne">Overview</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($page_two) active @endif" wire:click="pageTwo">Edit Profile</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($page_three) active @endif" wire:click="pageThree">Change Password</button>
                            </li>

                        </ul>

                        <div class="tab-content pt-2">
                            @if($page_one)
                            <div class="tab-pane fade show active profile-overview" id="profile-overview" role="tabpanel">
                                <!-- <h5 class="card-title">About</h5>
                                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Organization Name</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->organization_name}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date Established</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->date_established}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->address}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Representatives' Name</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->representative_name}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Representatives' Position</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->representative_position}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Representatives' Contact No.</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->organization_information->representative_contact_number}}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Organizations' Contact No.</div>
                                    <div class="col-lg-9 col-md-8">{{Auth::user()->contactNumber}}</div>
                                </div>
                            </div>
                            @endif

                            @if($page_two)
                            <div class="tab-pane fade show active pt-3" id="profile-edit" role="tabpanel">

                                <!-- Profile Edit Form -->
                                <form wire:submit="update">

                                    <!-- <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="assets/img/profile-img.jpg" alt="Profile">
                                            <div class="pt-2">
                                                <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="row mb-3">
                                        <label for="org_name" class="col-md-4 col-lg-3 col-form-label">Organization Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" wire:model.live="organization_name">
                                            @error('organization_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" row mb-3">
                                        <label for="date_estab" class="col-md-4 col-lg-3 col-form-label">Date Established</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="date" class="form-control @error('date_established') is-invalid @enderror" wire:model.live="date_established">
                                            @error('date_established')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="org_contact" class="col-md-4 col-lg-3 col-form-label">Organizations' Contact No.</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '').substring(0, 11)" class="form-control @error('contactNumber') is-invalid @enderror" wire:model.live="contactNumber">
                                            @error('contactNumber')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" wire:model.live="address">
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="rep_name" class="col-md-4 col-lg-3 col-form-label">Representatives' Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('representative_name') is-invalid @enderror" wire:model.live="representative_name">
                                            @error('representative_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="rep_pos" class="col-md-4 col-lg-3 col-form-label">Representatives' Position</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('representative_position') is-invalid @enderror" wire:model.live="representative_position">
                                            @error('representative_position')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="rep_phone" class="col-md-4 col-lg-3 col-form-label">Representatives' Contact Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control @error('representative_contact_number') is-invalid @enderror" wire:model.live="representative_contact_number">
                                            @error('representative_contact_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.live="email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="confirmPass" class="col-md-4 col-lg-3 col-form-label">Confirm with your current password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" wire:model="current_password">
                                            @error('current_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                            @endif

                            @if($page_three)
                            <div class="tab-pane fade active show pt-3" id="profile-change-password" role="tabpanel">

                                <!-- Change Password Form -->
                                <form wire:submit="changePassword">

                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" class="form-control @error('currentPass') is-invalid @enderror" wire:model.live="currentPass">
                                            @error('currentPass')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" class="form-control @error('newPass') is-invalid @enderror" wire:model.live="newPass">
                                            @error('newPass')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="password" class="form-control @error('confirmPass') is-invalid @enderror" wire:model.live="confirmPass">
                                            @error('confirmPass')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form>
                                <!-- End Change Password Form -->

                            </div>
                            @endif
                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</div>