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

        <div class="col-12">
            <div class="card border border-secondary" wire:loading.class="opacity-50" wire:target="pageOne, pageTwo, pageThree">
                <div class="row mx-5 mt-4">

                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                </div>

                <div class="row mx-5 mt-4 mb-4">
                    <div class="col text-center table-responsive">
                        <div class="text-start" style="color: #0A335D;">
                            <h1>Clients</h1>
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
                        <div class="text-end mt-2">
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
                    <form action="">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">User Type</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected="" disabled>Select</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                                <option value="other">Others</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Extension Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Birthday</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Address</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">School</label>
                            <select class="form-select" aria-label="Default select example">
                                <option value="" disabled {{ old('school') ? '' : 'selected' }}>Select...</option>
                                @foreach(\App\Models\SchoolInformationModel::all() as $school)
                                <option value="{{ $school['id'] }}" {{ old('school') == $school['id'] ? 'selected' : '' }}>{{ $school['school_name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">In case of emergency</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Emergency contact no.</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success fw-bolder mt-2" style="width: 140px;" wire:click="">SAVE</button>
                </div>
            </div>
        </div>
    </div>

</div>