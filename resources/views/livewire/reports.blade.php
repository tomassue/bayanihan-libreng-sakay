<div>
    <div>
        <style>
            .custom-border {
                border: 1px solid #dee2e6;
                /* Set your preferred border color here */
                border-radius: 0.25rem;
                /* Optional: Add border radius for a rounded appearance */
            }

            .custom-border thead th,
            .custom-border tbody tr:last-child td {
                border-bottom: none;
                /* Remove border for the last row in tbody */
            }
        </style>

        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-12">
            <div class="card border border-secondary" wire:loading.class="opacity-50" wire:target="pageOne, pageTwo, pageThree">
                <div class="row mx-5 mt-4">

                </div>

                <div class="row mx-5 mt-4 mb-4">
                    <div class="col text-center table-responsive">
                        <div class="text-start" style="color: #0A335D;">
                            <h1>Clients</h1>
                        </div>
                        <div class="input-group mb-4 mt-4">
                            <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Clients" wire:model.live.debounce.300ms="search_client">
                        </div>
                        @if($noRecordsclients)
                        <div class="pagination-info pt-4">
                            <p class="text-center">No records found.</p>
                        </div>
                        @else
                        <div class="pagination-info pb-2 text-start">
                            Page {{ $currentPageclients }} out of {{ $totalPagesclients }}, Total Records: {{ $totalRecordsclients }}
                        </div>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">CLIENT'S NAME</th>
                                    <th scope="col">ADDRESS</th>
                                    <th scope="col">CONTACT NUMBER</th>
                                    <th scope="col">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                    <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                                </tr>
                                @foreach($clients as $client)
                                <tr style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;" wire:key="{{ $client->id }}">
                                    <th scope="row">{{ $client->last_name . ', ' . $client->first_name . ($client->middle_name ? ' ' . $client->middle_name : '') . ($client->ext_name ? ' ' . $client->middle_name . '.' : '') }}</th>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>
                                        <a href="{{ route('generate.qr', encrypt($client->id)) }}" target="_blank">
                                            <button type="button" class="btn btn-success fw-bold mx-auto" style="width: 100px; height: 30px; padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;">GENERATE</button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end mt-2 mb-3">
                            @if(Auth::user()->user_id == 'ADMIN')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#addClientModal">ADD CLIENT</button>
                            @endif
                        </div>
                        {{ $clients->links('vendor.livewire.custom-pagination') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addClientModal -->
    <div wire:ignore.self class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="addClientModalLabel">Add Client</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form wire:submit="saveClient">
                            <div class="container row">

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">User Type</label>
                                        <div class="col-12">
                                            <select name="user_type" id="user_type" autocomplete="user_type" autofocus class="form-select @error('user_type') is-invalid @enderror" aria-label="Default select example" wire:model.live="user_type">
                                                <option value="" {{ old('user_type') ? '' : 'selected' }}>Select...</option>
                                                <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                                                <option value="school_staff" {{ old('user_type') == 'school_staff' ? 'selected' : '' }}>School Staff</option>
                                                <option value="city_hall_employee" {{ old('user_type') == 'city_hall_employee' ? 'selected' : '' }}>City Hall Employee</option>
                                                <option value="city_hall_client" {{ old('user_type') == 'city_hall_client' ? 'selected' : '' }}>City Hall Client</option>
                                                <option value="other" {{ old('user_type') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('user_type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Last Name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="last_name">
                                            @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">First Name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="first_name">
                                            @error('first_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Middle Name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="middle_name">
                                            @error('middle_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Extension Name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('ext_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="ext_name">
                                            @error('ext_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Sex</label>
                                        <div class="col-12">
                                            <select class="form-select @error('sex') is-invalid @enderror" aria-label="Default select example" wire:model.live="sex">
                                                <option value="" {{ old('sex') ? '' : 'selected' }}>Select...</option>
                                                <option value="m" {{ old('sex') ? '' : 'selected' }}>Male</option>
                                                <option value="f" {{ old('sex') ? '' : 'selected' }}>Female</option>
                                            </select>
                                            @error('sex')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Birthday</label>
                                        <div class="col-12">
                                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="birthday">
                                            @error('birthday')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Contact Number</label>
                                        <div class="col-12">
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '').substring(0, 11)" class="form-control @error('contact_number') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="contact_number">
                                            @error('contact_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Address</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="address">
                                            @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">School</label>
                                        <div class="col-12">
                                            <select class="form-select @error('school') is-invalid @enderror" aria-label="Default select example" wire:model.live="school">
                                                <option value="" {{ old('school') ? '' : 'selected' }}>Select...</option>
                                                @foreach(\App\Models\SchoolInformationModel::all() as $school)
                                                <option value="{{ $school['id'] }}" {{ old('school') == $school['id'] ? 'selected' : '' }}>{{ $school['school_name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('school')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Emergency contact name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('emergency_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="emergency_name">
                                            @error('emergency_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Emergency contact no.</label>
                                        <div class="col-12">
                                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '').substring(0, 11)" class="form-control @error('emergency_contact_no') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="emergency_contact_no">
                                            @error('emergency_contact_no')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: 65px;">SAVE</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>

@script
<script>
    $wire.on('close-addClientModal-Modal', () => {
        $('#addClientModal').modal('hide');
    });
</script>
@endscript