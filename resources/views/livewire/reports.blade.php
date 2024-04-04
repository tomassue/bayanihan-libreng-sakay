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
            <div class="card border border-secondary">
                <div class="row mx-5 mt-4">
                    <div class="text-start" style="color: #0A335D;">
                        <h1>Clients</h1>
                    </div>
                </div>

                <div class="row mx-5 mt-4">
                    <div class="col-sm-12 col-lg-5">
                        <form wire:submit="search">
                            <div class="row g-2 mb-2">
                                <label for="inputEmail3" class="col-sm-4 col-md-2 col-lg-2 col-form-label">Date</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="start_date">
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="end_date">
                                </div>
                            </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-2 text-start">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
                        </form>
                    </div>
                </div>


                <div class="row mx-5 mb-4">
                    <div class="col text-center table-responsive">
                        <div class="input-group mb-4 mt-4">
                            <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Clients" wire:model.live.debounce.300ms="search_client">
                        </div>
                        @if($noRecordsclients)
                        <div class="pagination-info pt-4">
                            <p class="text-center">No records found.</p>
                        </div>
                        @else

                        <div class="row g-2 mb-2 mt-2">
                            <div class="col-sm-4 text-start">
                                <a href="{{ route('pdf-report-clients', [
                                    'start_date' => $start_date !== '' ? $start_date : 'null',
                                    'end_date' => $end_date !== '' ? $end_date : 'null',
                                    'search_client' => $search_client !== '' ? $search_client : 'null',
                                ]) }}" target="_blank">
                                    <button type="button" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M7.25 7h9.5V5c0-2-.75-3-3-3h-3.5c-2.25 0-3 1-3 3v2ZM16 15v4c0 2-1 3-3 3h-2c-2 0-3-1-3-3v-4h8Z" stroke="#d9e3f0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M21 10v5c0 2-1 3-3 3h-2v-3H8v3H6c-2 0-3-1-3-3v-5c0-2 1-3 3-3h12c2 0 3 1 3 3ZM17 15H7M7 11h3" stroke="#d9e3f0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </a>

                                <button type="button" class="btn btn-primary" wire:click="export" wire:loading.attr="disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 11v6l2-2M9 17l-2-2" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M22 10v5c0 5-2 7-7 7H9c-5 0-7-2-7-7V9c0-5 2-7 7-7h5" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M22 10h-4c-3 0-4-1-4-4V2l8 8Z" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="col-sm-8">
                                <div class="pagination-info pb-2 text-end">
                                    Page {{ $currentPageclients }} out of {{ $totalPagesclients }}, Total Records: {{ $totalRecordsclients }}
                                </div>
                            </div>
                        </div>

                        <table class="table table-borderless" wire:loading.class="opacity-50">
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
                                    <th scope="row">{{ $client->last_name . ', ' . $client->first_name . ($client->middle_name ? ' ' . $client->middle_name : '') . ($client->ext_name ? ' ' . $client->ext_name . '.' : '') }}</th>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>
                                        <a href="{{ route('generate.qr', encrypt($client->id)) }}" target="_blank">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                                <path d="M2 9V6.5C2 4.01 4.01 2 6.5 2H9M15 2h2.5C19.99 2 22 4.01 22 6.5V9M22 16v1.5c0 2.49-2.01 4.5-4.5 4.5H16M9 22H6.5C4.01 22 2 19.99 2 17.5V15M10.5 7v2c0 1-.5 1.5-1.5 1.5H7c-1 0-1.5-.5-1.5-1.5V7C5.5 6 6 5.5 7 5.5h2c1 0 1.5.5 1.5 1.5ZM18.5 7v2c0 1-.5 1.5-1.5 1.5h-2c-1 0-1.5-.5-1.5-1.5V7c0-1 .5-1.5 1.5-1.5h2c1 0 1.5.5 1.5 1.5ZM10.5 15v2c0 1-.5 1.5-1.5 1.5H7c-1 0-1.5-.5-1.5-1.5v-2c0-1 .5-1.5 1.5-1.5h2c1 0 1.5.5 1.5 1.5ZM18.5 15v2c0 1-.5 1.5-1.5 1.5h-2c-1 0-1.5-.5-1.5-1.5v-2c0-1 .5-1.5 1.5-1.5h2c1 0 1.5.5 1.5 1.5Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                        <span style="cursor: pointer;" wire:click="transactHistory('{{ $client->id }}')" data-bs-toggle="modal" data-bs-target="#clientHistoryModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 7v10c0 3-1.5 5-5 5H8c-3.5 0-5-2-5-5V7c0-3 1.5-5 5-5h8c3.5 0 5 2 5 5Z" stroke="#000000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M14.5 4.5v2c0 1.1.9 2 2 2h2M8 13h4M8 17h8" stroke="#000000" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $clients->links('vendor.livewire.custom-pagination') }}
                        @endif
                        <div class="text-end mt-2 mb-3">
                            @if(Auth::user()->user_id == 'ADMIN')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#addClientModal">ADD CLIENT</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- clientHistoryModal -->
    <div wire:ignore.self class="modal fade" id="clientHistoryModal" tabindex="-1" aria-labelledby="clientHistoryModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="clientHistoryModalLabel">Details</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body" wire:loading.remove>
                    <div class="row">
                        @if($client_details)
                        <div class="col-7 row">
                            <div class="col row">
                                <div class="col-12">
                                    <h5 class="card-title" style="padding-top: 0px;">Clients' profile</span></h5>
                                    <div class="col">
                                        Name: {{$client_details->client_fullname}}
                                    </div>
                                    <div class="col">
                                        Sex: {{strtoupper($client_details->sex)}}
                                    </div>
                                    <div class="col">
                                        Birthday: {{$client_details->birthday}}
                                    </div>
                                    <div class="col">
                                        Address: {{$client_details->address}}
                                    </div>
                                    <div class="col">
                                        School: {{$client_details->school != 'NULL' ? $client_details->school : 'N/A'}}
                                    </div>
                                    <div class="col">
                                        Guardian: {{$client_details->guardian_name}}
                                    </div>
                                    <div class="col">
                                        Guardians' phone no.: {{$client_details->guardian_contact_number}}
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-6">
                                Other details
                            </div> -->
                        </div>
                        @endif

                        <div class="col-5 activity">
                            @if($client_transact->count() == 0)
                            <div class="text-center">
                                No transactions found.
                            </div>
                            @else
                            <h5 class="card-title" style="padding-top: 0px;">Transaction History</span></h5>
                            @foreach($client_transact as $client_transactions)
                            <div class="activity-item d-flex overflow-auto">
                                <div class="activite-label">{{$client_transactions->transaction_time}}</div>
                                <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                                <div class="activity-content">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M9 22h6c5 0 7-2 7-7V9c0-5-2-7-7-7H9C4 2 2 4 2 9v6c0 5 2 7 7 7Z" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="m7.33 14.49 2.38-3.09c.34-.44.97-.52 1.41-.18l1.83 1.44c.44.34 1.07.26 1.41-.17l2.31-2.98" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        {{$client_transactions->event_name}}
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 13.43a3.12 3.12 0 1 0 0-6.24 3.12 3.12 0 0 0 0 6.24Z" stroke="#0f0f0f" stroke-width="1.5"></path>
                                            <path d="M3.62 8.49c1.97-8.66 14.8-8.65 16.76.01 1.15 5.08-2.01 9.38-4.78 12.04a5.193 5.193 0 0 1-7.21 0c-2.76-2.66-5.92-6.97-4.77-12.05Z" stroke="#0f0f0f" stroke-width="1.5"></path>
                                        </svg>
                                        {{$client_transactions->event_location}}
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M8 2v3M16 2v3M3.5 9.09h17M21 8.5V17c0 3-1.5 5-5 5H8c-3.5 0-5-2-5-5V8.5c0-3 1.5-5 5-5h8c3.5 0 5 2 5 5Z" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M15.695 13.7h.009M15.695 16.7h.009M11.995 13.7h.01M11.995 16.7h.01M8.294 13.7h.01M8.294 16.7h.01" stroke="#0f0f0f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        {{$client_transactions->transaction_date}}
                                    </div>
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M12.16 10.87c-.1-.01-.22-.01-.33 0a4.42 4.42 0 0 1-4.27-4.43C7.56 3.99 9.54 2 12 2a4.435 4.435 0 0 1 .16 8.87ZM7.16 14.56c-2.42 1.62-2.42 4.26 0 5.87 2.75 1.84 7.26 1.84 10.01 0 2.42-1.62 2.42-4.26 0-5.87-2.74-1.83-7.25-1.83-10.01 0Z" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        {{$client_transactions->rider_name}}
                                    </div>
                                    @if($client_transactions->status == 1)
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M3.62 8.49c1.97-8.66 14.8-8.65 16.76.01 1.15 5.08-2.01 9.38-4.78 12.04a5.194 5.194 0 0 1-7.21 0c-2.76-2.66-5.92-6.97-4.77-12.05Z" stroke="#0f0f0f" stroke-width="1.5"></path>
                                            <path d="m9.25 11.5 1.5 1.5 4-4" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        {{ucfirst($client_transactions->destination) . " - " . $client_transactions->time_drop}}
                                    </div>
                                    @endif
                                    <!-- <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae -->
                                </div>
                            </div><!-- End activity item--><!-- End activity item-->
                            @endforeach
                            @endif
                        </div>
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
                                            <select class="form-select @error('ext_name') is-invalid @enderror" name="ext_name" id="ext_name" aria-label="ext_name" wire:model="ext_name">
                                                <option value="" {{ old('ext_name') ? '' : 'selected' }}>Select...</option>

                                                @php
                                                // Function to convert Arabic numbers to Roman numerals
                                                function arabicToRoman($num) {
                                                $roman = '';
                                                $lookup = array(
                                                'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9,
                                                'V' => 5, 'IV' => 4, 'I' => 1
                                                );

                                                foreach ($lookup as $symbol => $value) {
                                                while ($num >= $value) {
                                                $roman .= $symbol;
                                                $num -= $value;
                                                }
                                                }
                                                return $roman;
                                                }

                                                // Loop for Jr. and Sr.
                                                $suffixes = ['Jr.', 'Sr.'];
                                                foreach ($suffixes as $suffix) {
                                                echo "<option value=\"$suffix\" " . (old('ext_name') == $suffix ? 'selected' : '') . ">$suffix</option>";
                                                }

                                                // Loop for Roman numerals up to 50
                                                for ($i = 1; $i <= 50; $i++) { $romanNumeral=arabicToRoman($i); echo "<option value=\" $romanNumeral\" " . (old('ext_name') == $romanNumeral ? 'selected' : '') . ">$romanNumeral</option>";
                                                    }
                                                    @endphp
                                            </select>

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
                                            <select class="form-select @error('school') is-invalid @enderror" aria-label="Default select example" wire:model.live="school" @if($user_type !=='student' && $user_type !=='school_staff' ) disabled @endif>
                                                <option value="" {{ old('school') ? '' : 'selected' }}>Select...</option>
                                                @foreach(\App\Models\SchoolInformationModel::where('status', 1)->get() as $school)
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
                                            <!-- <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '').substring(0, 11)" class="form-control @error('emergency_contact_no') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="emergency_contact_no"> -->
                                            <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                                <option value="AL">Alabama</option>
                                                ...
                                                <option value="WY">Wyoming</option>
                                            </select>

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
                    <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: 65px;" wire:loading.class="opacity-50">SAVE</button>
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

    $(livewire).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endscript