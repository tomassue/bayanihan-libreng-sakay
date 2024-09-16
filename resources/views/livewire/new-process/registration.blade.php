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

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            border-top: unset;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #000;
        }

        .separator:not(:empty)::before {
            margin-right: .25em;
        }

        .separator:not(:empty)::after {
            margin-left: .25em;
        }
    </style>

    <div class="col-12">
        <div class="card border border-secondary">
            <div class="row mx-5 mt-4">

            </div>

            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <div class="text-start" style="color: #0A335D;">
                        <h1>Registration</h1>
                    </div>

                    <div class="input-group mb-4 mt-4">
                        <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Search" wire:model.live="search">
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-1 col-form-label text-start">Filter</label>
                        <div class="col-sm-3">
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="filter_accountType">
                                <option selected="" value="">Account type</option>
                                @foreach ($accountType as $item)
                                <option value="{{ $item->id }}">{{ $item->account_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="pagination-info pb-2 text-end">
                        Page {{ $combined->currentPage() }} out of {{ $combined->lastPage() }}, Total Records: {{ $combined->total() }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">ACCOUNT TYPE</th>
                                <th scope="col">PHONE NUMBER</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($combined as $key=>$item)
                            <tr wire:key="{{ $item->user_id }}">
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->account_type }} {{ $item->user_type }}</td>
                                <td>{{ $item->contactNumber }}</td>
                                <td>
                                    <span style="cursor: pointer;" title="Edit" wire:click="edit('{{ $item->user_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <span style="cursor: pointer;" title="Status history" wire:click="statusHistory('{{ $item->user_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z" />
                                            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z" />
                                            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5" />
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $combined->links('vendor.livewire.custom-pagination') }}
                    <div class="text-end mt-2 mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" wire:click="$dispatch('show_addModal')">ADD RECORD</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- addModal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="addModalLabel">{{ $editMode ? 'Edit' : 'Add' }} {{ $account_type }}</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;" wire:click="clear"></button>
                </div>

                <div class="modal-body" wire:loading.remove>
                    <form class="row g-3" data-bitwarden-watching="1" novalidate wire:submit="{{ $editMode ? 'update' : 'add' }}">
                        <div class="col-md-12">
                            <label for="inputAccountType" class="form-label">Account Type</label>
                            <select class="form-select @error('account_type') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="account_type" {{ $editMode ? 'disabled' : '' }}>
                                <option selected="" value="">Select</option>
                                <option value="rider">Rider</option>
                                <option value="client">Client</option>
                                <option value="organization">Organization</option>
                            </select>
                            @error('account_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if ($account_type)

                        @if ($account_type == 'rider')
                        <div class="separator">
                            <span class="fs-5">Rider</span>
                        </div>
                        @elseif($account_type == 'organization')
                        <div class="separator">
                            <span class="fs-5">Organization</span>
                        </div>
                        @elseif($account_type == 'client')
                        <div class="separator">
                            <span class="fs-5">Client</span>
                        </div>
                        <div class="col-md-12" style="margin-top: 0px;">
                            <label for="inputFirstName" class="form-label">User Type</label>
                            <select class="form-select @error('user_type') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="user_type">
                                <option selected="">Select</option>
                                <option value="student">Student</option>
                                <option value="school_staff">School Staff</option>
                                <option value="city_hall_employee">City Hall Employee</option>
                                <option value="city_hall_client">City Hall Client</option>
                                <option value="other">Other</option>
                            </select>
                            @error('user_type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @if ($account_type !== 'organization')
                        <div class="col-md-4">
                            <label for="inputFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="inputFirstName" data-ddg-inputtype="identities.first_name" wire:model="first_name">
                            @error('first_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="inputMiddleName" data-ddg-inputtype="identities.middle_name" wire:model="middle_name">
                            @error('middle_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="inputLastName" data-ddg-inputtype="identities.last_name" wire:model="last_name">
                            @error('last_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputAddress" class="form-label">Ext. Name</label>
                            <select class="form-select @error('ext_name') is-invalid @enderror" id="extensionName" aria-label="extensionName" wire:model="ext_name">
                                <option value="" {{ old('ext_name') ? '' : 'selected' }}>Select</option>
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
                                echo "<option value=\"$suffix\" " . (old('extensionName') == $suffix ? 'selected' : '') . ">$suffix</option>";
                                }

                                // Loop for Roman numerals up to 50
                                for ($i = 1; $i <= 50; $i++)
                                    {
                                    $romanNumeral=arabicToRoman($i); echo "<option value=\" $romanNumeral\" " . (old('extensionName') == $romanNumeral ? 'selected' : '') . ">$romanNumeral</option>";
                                    }
                                    @endphp
                            </select>
                            @error('ext_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="inputSex" class="form-label">Sex</label>
                            <select class="form-select @error('sex') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="sex">
                                <option selected="">Select</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                            @error('sex')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputContactNumber" class="form-label">Contact Number</label>
                            <input type="text" maxlength="11" oninput="this.value = '09' + this.value.slice(2).replace(/\D/g, '');" placeholder="09XXXXXXXXX" class="form-control @error('contactNumber') is-invalid @enderror" id="inputContactNumber" data-ddg-inputtype="identities.contactNumber" wire:model="contactNumber">
                            @error('contactNumber')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Barangay</label>
                            <select class="form-select @error('id_barangay') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="id_barangay">
                                <option selected="">Select</option>
                                @foreach ($barangay as $item)
                                <option value="{{ $item->id }}">{{ $item->barangay }}</option>
                                @endforeach
                                <option value="other_city">OTHER CITY</option>
                            </select>
                            @error('id_barangay')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @if ($account_type == 'organization')
                        <div class="col-md-4">
                            <label for="inputOrganizationName" class="form-label">Organization Name</label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" id="inputOrganizationName" data-ddg-inputtype="identities.organization_name" wire:model="organization_name">
                            @error('organization_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputDateEstablished" class="form-label">Date Established</label>
                            <input type="date" class="form-control @error('date_established') is-invalid @enderror" id="inputDateEstablished" data-ddg-inputtype="identities.date_established" wire:model="date_established">
                            @error('date_established')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputOrganizationContactNumber" class="form-label">Organization's Contact Number</label>
                            <input type="text" maxlength="11" oninput="this.value = '09' + this.value.slice(2).replace(/\D/g, '');" placeholder="09XXXXXXXXX" class="form-control @error('contactNumber') is-invalid @enderror" id="inputOrganizationContactNumber" data-ddg-inputtype="identities.organization_contact_number" wire:model="contactNumber">
                            @error('contactNumber')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        <div class="{{ $account_type == 'organization' ? 'col-md-12' : 'col-md-8' }}">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="inputAddress" data-ddg-inputtype="identities.addressStreet" wire:model="address">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="custom-error-message" style="display: {{ $id_barangay == 'other_city' ? 'block' : 'none' }}">
                                Since you've selected "Other City", please input the full address here, including the barangay.
                            </div>
                        </div>

                        @if ($account_type == 'organization')
                        <div class="col-md-4">
                            <label for="inputRepresentativeName" class="form-label">Representative's Name</label>
                            <input type="text" class="form-control @error('representative_name') is-invalid @enderror" id="inputRepresentativeName" data-ddg-inputtype="identities.representative_name" wire:model="representative_name">
                            @error('representative_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputRepresentativePosition" class="form-label">Representative's Position</label>
                            <input type="text" class="form-control @error('representative_position') is-invalid @enderror" id="inputRepresentativePosition" data-ddg-inputtype="identities.representative_position" wire:model="representative_position">
                            @error('representative_position')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="inputRepresentativeContactNumber" class="form-label">Representative's Contact Number</label>
                            <input type="text" maxlength="11" oninput="this.value = '09' + this.value.slice(2).replace(/\D/g, '');" placeholder="09XXXXXXXXX" class="form-control @error('representative_contact_number') is-invalid @enderror" id="inputRepresentativeContactNumber" data-ddg-inputtype="identities.representative_contact_number" wire:model="representative_contact_number">
                            @error('representative_contact_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @if ($account_type == 'rider')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Organization</label>
                            <select class="form-select @error('id_organization') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="id_organization" {{ $organization_count == 0 ? 'disabled' : '' }}>
                                <option selected="">Select</option>
                                @foreach ($organization as $item)
                                <option value="{{ $item->id }}">{{ $item->organization_name }}</option>
                                @endforeach
                            </select>
                            <div class="custom-error-message" style="display: {{ $organization_count == 0 ? 'block' : 'none' }}">
                                No organization has been registered. Please register an organization first.
                            </div>
                            @error('id_organization')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @elseif($account_type == 'client')
                        <div class="col-md-4">
                            <label for="inputBirthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="inputBirthday" data-ddg-inputtype="identities.birthday" wire:model="birthday">
                            @error('birthday')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="inputEmail4" class="form-label">School</label>
                            <select class="form-select @error('id_school') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="id_school" {{ $user_type == 'student' || $user_type == 'school_staff' ? '' : 'disabled' }}>
                                <option selected="">Select</option>
                                @foreach ($school as $item)
                                <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                                @endforeach
                            </select>
                            @error('id_school')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContactName" class="form-label">Emergency contact name</label>
                            <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" id="inputEmergencyContactName" data-ddg-inputtype="identities.contactNumber" wire:model="guardian_name">
                            @error('guardian_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContactNumber" class="form-label">Emergency contact Number</label>
                            <input type="text" maxlength="11" oninput="this.value = '09' + this.value.slice(2).replace(/\D/g, '');" placeholder="09XXXXXXXXX" class="form-control @error('guardian_contact_number') is-invalid @enderror" id="inputEmergencyContactNumber" data-ddg-inputtype="identities.contactNumber" wire:model="guardian_contact_number">
                            @error('guardian_contact_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @if ($account_type == 'rider' || $account_type == 'organization')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail4" wire:model="email" data-ddg-inputtype="identities.emailAddress" data-ddg-autofill="true" style="background-size: auto 24px !important; background-position: right center !important; background-repeat: no-repeat !important; background-origin: content-box !important; background-image: url(&quot;data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTI4IiBoZWlnaHQ9IjEyOCIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDEyOCAxMjgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8cGF0aCBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Im02NCAxMjhjMzUuMzQ2IDAgNjQtMjguNjU0IDY0LTY0cy0yOC42NTQtNjQtNjQtNjQtNjQgMjguNjU0LTY0IDY0IDI4LjY1NCA2NCA2NCA2NHoiIGZpbGw9IiNkZTU4MzMiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNzMgMTExLjc1YzAtLjUuMTIzLS42MTQtMS40NjYtMy43ODItNC4yMjQtOC40NTktOC40Ny0yMC4zODQtNi41NC0yOC4wNzUuMzUzLTEuMzk3LTMuOTc4LTUxLjc0NC03LjA0LTUzLjM2NS0zLjQwMi0xLjgxMy03LjU4OC00LjY5LTExLjQxOC01LjMzLTEuOTQzLS4zMS00LjQ5LS4xNjQtNi40ODIuMTA1LS4zNTMuMDQ3LS4zNjguNjgzLS4wMy43OTggMS4zMDguNDQzIDIuODk1IDEuMjEyIDMuODMgMi4zNzUuMTc4LjIyLS4wNi41NjYtLjM0Mi41NzctLjg4Mi4wMzItMi40ODIuNDAyLTQuNTkzIDIuMTk1LS4yNDQuMjA3LS4wNDEuNTkyLjI3My41MyA0LjUzNi0uODk3IDkuMTctLjQ1NSAxMS45IDIuMDI3LjE3Ny4xNi4wODQuNDUtLjE0Ny41MTItMjMuNjk0IDYuNDQtMTkuMDAzIDI3LjA1LTEyLjY5NiA1Mi4zNDQgNS42MTkgMjIuNTMgNy43MzMgMjkuNzkyIDguNCAzMi4wMDRhLjcxOC43MTggMCAwIDAgLjQyMy40NjdjOC4xNTYgMy4yNDggMjUuOTI4IDMuMzkyIDI1LjkyOC0yLjEzMnoiIGZpbGw9IiNkZGQiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggZD0ibTc2LjI1IDExNi41Yy0yLjg3NSAxLjEyNS04LjUgMS42MjUtMTEuNzUgMS42MjUtNC43NjQgMC0xMS42MjUtLjc1LTE0LjEyNS0xLjg3NS0xLjU0NC00Ljc1MS02LjE2NC0xOS40OC0xMC43MjctMzguMTg1bC0uNDQ3LTEuODI3LS4wMDQtLjAxNWMtNS40MjQtMjIuMTU3LTkuODU1LTQwLjI1MyAxNC40MjctNDUuOTM4LjIyMi0uMDUyLjMzLS4zMTcuMTg0LS40OTItMi43ODYtMy4zMDUtOC4wMDUtNC4zODgtMTQuNjA1LTIuMTExLS4yNy4wOTMtLjUwNi0uMTgtLjMzNy0uNDEyIDEuMjk0LTEuNzgzIDMuODIzLTMuMTU1IDUuMDcxLTMuNzU2LjI1OC0uMTI0LjI0Mi0uNTAyLS4wMy0uNTg4YTI3Ljg3NyAyNy44NzcgMCAwIDAgLTMuNzcyLS45Yy0uMzctLjA1OS0uNDAzLS42OTMtLjAzMi0uNzQzIDkuMzU2LTEuMjU5IDE5LjEyNSAxLjU1IDI0LjAyOCA3LjcyNmEuMzI2LjMyNiAwIDAgMCAuMTg2LjExNGMxNy45NTIgMy44NTYgMTkuMjM4IDMyLjIzNSAxNy4xNyAzMy41MjgtLjQwOC4yNTUtMS43MTUuMTA4LTMuNDM4LS4wODUtNi45ODYtLjc4MS0yMC44MTgtMi4zMjktOS40MDIgMTguOTQ4LjExMy4yMS0uMDM2LjQ4OC0uMjcyLjUyNS02LjQzOCAxIDEuODEyIDIxLjE3MyA3Ljg3NSAzNC40NjF6IiBmaWxsPSIjZmZmIi8+CiAgICA8cGF0aCBkPSJtODQuMjggOTAuNjk4Yy0xLjM2Ny0uNjMzLTYuNjIxIDMuMTM1LTEwLjExIDYuMDI4LS43MjgtMS4wMzEtMi4xMDMtMS43OC01LjIwMy0xLjI0Mi0yLjcxMy40NzItNC4yMTEgMS4xMjYtNC44OCAyLjI1NC00LjI4My0xLjYyMy0xMS40ODgtNC4xMy0xMy4yMjktMS43MS0xLjkwMiAyLjY0Ni40NzYgMTUuMTYxIDMuMDAzIDE2Ljc4NiAxLjMyLjg0OSA3LjYzLTMuMjA4IDEwLjkyNi02LjAwNS41MzIuNzQ5IDEuMzg4IDEuMTc4IDMuMTQ4IDEuMTM3IDIuNjYyLS4wNjIgNi45NzktLjY4MSA3LjY0OS0xLjkyMS4wNC0uMDc1LjA3NS0uMTY0LjEwNS0uMjY2IDMuMzg4IDEuMjY2IDkuMzUgMi42MDYgMTAuNjgyIDIuNDA2IDMuNDctLjUyMS0uNDg0LTE2LjcyMy0yLjA5LTE3LjQ2N3oiIGZpbGw9IiMzY2E4MmIiLz4KICAgIDxwYXRoIGQ9Im03NC40OSA5Ny4wOTdjLjE0NC4yNTYuMjYuNTI2LjM1OC44LjQ4MyAxLjM1MiAxLjI3IDUuNjQ4LjY3NCA2LjcwOS0uNTk1IDEuMDYyLTQuNDU5IDEuNTc0LTYuODQzIDEuNjE1cy0yLjkyLS44MzEtMy40MDMtMi4xODFjLS4zODctMS4wODEtLjU3Ny0zLjYyMS0uNTcyLTUuMDc1LS4wOTgtMi4xNTguNjktMi45MTYgNC4zMzQtMy41MDYgMi42OTYtLjQzNiA0LjEyMS4wNzEgNC45NDQuOTQgMy44MjgtMi44NTcgMTAuMjE1LTYuODg5IDEwLjgzOC02LjE1MiAzLjEwNiAzLjY3NCAzLjQ5OSAxMi40MiAyLjgyNiAxNS45MzktLjIyIDEuMTUxLTEwLjUwNS0xLjEzOS0xMC41MDUtMi4zOCAwLTUuMTUyLTEuMzM3LTYuNTY1LTIuNjUtNi43MXptLTIyLjUzLTEuNjA5Yy44NDMtMS4zMzMgNy42NzQuMzI1IDExLjQyNCAxLjk5MyAwIDAtLjc3IDMuNDkxLjQ1NiA3LjYwNC4zNTkgMS4yMDMtOC42MjcgNi41NTgtOS44IDUuNjM3LTEuMzU1LTEuMDY1LTMuODUtMTIuNDMyLTIuMDgtMTUuMjM0eiIgZmlsbD0iIzRjYmEzYyIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNTUuMjY5IDY4LjQwNmMuNTUzLTIuNDAzIDMuMTI3LTYuOTMyIDEyLjMyMS02LjgyMiA0LjY0OC0uMDE5IDEwLjQyMi0uMDAyIDE0LjI1LS40MzZhNTEuMzEyIDUxLjMxMiAwIDAgMCAxMi43MjYtMy4wOTVjMy45OC0xLjUxOSA1LjM5Mi0xLjE4IDUuODg3LS4yNzIuNTQ0Ljk5OS0uMDk3IDIuNzIyLTEuNDg4IDQuMzA5LTIuNjU2IDMuMDMtNy40MzEgNS4zOC0xNS44NjUgNi4wNzYtOC40MzMuNjk4LTE0LjAyLTEuNTY1LTE2LjQyNSAyLjExOC0xLjAzOCAxLjU4OS0uMjM2IDUuMzMzIDcuOTIgNi41MTIgMTEuMDIgMS41OSAyMC4wNzItMS45MTcgMjEuMTkuMjAxIDEuMTE5IDIuMTE4LTUuMzIzIDYuNDI4LTE2LjM2MiA2LjUxOHMtMTcuOTM0LTMuODY1LTIwLjM3OS01LjgzYy0zLjEwMi0yLjQ5NS00LjQ5LTYuMTMzLTMuNzc1LTkuMjc5eiIgZmlsbD0iI2ZjMyIgZmlsbC1ydWxlPSJldmVub2RkIi8+CiAgICA8ZyBmaWxsPSIjMTQzMDdlIiBvcGFjaXR5PSIuOCI+CiAgICAgIDxwYXRoIGQ9Im02OS4zMjcgNDIuMTI3Yy42MTYtMS4wMDggMS45ODEtMS43ODYgNC4yMTYtMS43ODYgMi4yMzQgMCAzLjI4NS44ODkgNC4wMTMgMS44OC4xNDguMjAyLS4wNzYuNDQtLjMwNi4zNGE1OS44NjkgNTkuODY5IDAgMCAxIC0uMTY4LS4wNzNjLS44MTctLjM1Ny0xLjgyLS43OTUtMy41NC0uODItMS44MzgtLjAyNi0yLjk5Ny40MzUtMy43MjcuODMxLS4yNDYuMTM0LS42MzQtLjEzMy0uNDg4LS4zNzJ6bS0yNS4xNTcgMS4yOWMyLjE3LS45MDcgMy44NzYtLjc5IDUuMDgxLS41MDQuMjU0LjA2LjQzLS4yMTMuMjI3LS4zNzctLjkzNS0uNzU1LTMuMDMtMS42OTItNS43Ni0uNjc0LTIuNDM3LjkwOS0zLjU4NSAyLjc5Ni0zLjU5MiA0LjAzOC0uMDAyLjI5Mi42LjMxNy43NTYuMDcuNDItLjY3IDEuMTItMS42NDYgMy4yODktMi41NTN6Ii8+CiAgICAgIDxwYXRoIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0ibTc1LjQ0IDU1LjkyYTMuNDcgMy40NyAwIDAgMSAtMy40NzQtMy40NjIgMy40NyAzLjQ3IDAgMCAxIDMuNDc1LTMuNDYgMy40NyAzLjQ3IDAgMCAxIDMuNDc0IDMuNDYgMy40NyAzLjQ3IDAgMCAxIC0zLjQ3NSAzLjQ2MnptMi40NDctNC42MDhhLjg5OS44OTkgMCAwIDAgLTEuNzk5IDBjMCAuNDk0LjQwNS44OTUuOS44OTUuNDk5IDAgLjktLjQuOS0uODk1em0tMjUuNDY0IDMuNTQyYTQuMDQyIDQuMDQyIDAgMCAxIC00LjA0OSA0LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSAtNC4wNS00LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSA0LjA1LTQuMDM3IDQuMDQ1IDQuMDQ1IDAgMCAxIDQuMDUgNC4wMzd6bS0xLjE5My0xLjMzOGExLjA1IDEuMDUgMCAwIDAgLTIuMDk3IDAgMS4wNDggMS4wNDggMCAwIDAgMi4wOTcgMHoiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPC9nPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNjQgMTE3Ljc1YzI5LjY4NSAwIDUzLjc1LTI0LjA2NSA1My43NS01My43NXMtMjQuMDY1LTUzLjc1LTUzLjc1LTUzLjc1LTUzLjc1IDI0LjA2NS01My43NSA1My43NSAyNC4wNjUgNTMuNzUgNTMuNzUgNTMuNzV6bTAgNWMzMi40NDcgMCA1OC43NS0yNi4zMDMgNTguNzUtNTguNzVzLTI2LjMwMy01OC43NS01OC43NS01OC43NS01OC43NSAyNi4zMDMtNTguNzUgNTguNzUgMjYuMzAzIDU4Ljc1IDU4Ljc1IDU4Ljc1eiIgZmlsbD0iI2ZmZiIgZmlsbC1ydWxlPSJldmVub2RkIi8+Cjwvc3ZnPg==&quot;) !important; transition: background !important;">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif

                        @endif

                        <!-- PASSWORD will be a default password for now. For the sake of the scalability if ever the original process is implement. -->

                </div>
                <div class="my-5 mx-auto" wire:loading>
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: auto;">{{ $editMode ? 'SAVE CHANGES' : 'SAVE' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- statusHistoryModal -->
    <div wire:ignore.self class="modal fade" id="statusHistoryModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="statusHistoryModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="statusHistoryModalLabel">Status History</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;" wire:click="clear"></button>
                </div>

                <div class="modal-body" wire:loading.remove>
                    <div class="activity">
                        @forelse($status_history as $item)
                        <div class="activity-item d-flex">
                            <div class="activite-label">{{ $item->formatted_created_at }}</div>
                            <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                            <div class="activity-content">
                                <p>{{ $item->admin }} {{ $item->action }}:</p>
                                <ul>
                                    @php
                                    $changes = json_decode($item->changes, true);
                                    @endphp
                                    @if ($changes)
                                    @foreach ($changes as $value)
                                    <li>{{ $value }}</li>
                                    @endforeach
                                    @else
                                    <li>No changes available.</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">
                            <span>No history</span>
                        </div>
                        @endforelse
                    </div>

                    <div class="my-5 mx-auto" wire:loading>
                        <div class="spinner-grow text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="button" class="btn btn-secondary fw-bolder mt-2" style="width: auto;" data-bs-dismiss="modal" wire:click="clear">Close</button>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('show_addModal', () => {
            $('#addModal').modal('show');
        });

        $wire.on('hide_addModal', () => {
            $('#addModal').modal('hide');
        });

        $wire.on('show_statusHistoryModal', () => {
            $('#statusHistoryModal').modal('show');
        });

        $wire.on('hide_statusHistoryModal', () => {
            $('#statusHistoryModal').modal('hide');
        });
    </script>
    @endscript