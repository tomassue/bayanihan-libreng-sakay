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
                        <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Search" wire:model.live.debounce.300ms="">
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NO.</th>
                                <th scope="col">SCHOOL NAME</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>sadsad</td>
                                <td>sadsad</td>
                                <td>sadsad</td>
                                <td>
                                    <span style="cursor: pointer;" wire:click="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- pagination here -->
                    <div class="text-end mt-2 mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" wire:click="$dispatch('show_addModal')">ADD RECORD</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- addModal -->
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="addModalLabel">Add {{ $account_type }}</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>

                <div class="modal-body" wire:loading.remove>
                    <form class="row g-3" data-bitwarden-watching="1" wire:submit="add">
                        <div class="col-md-12">
                            <label for="inputAccountType" class="form-label">Account Type</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="account_type">
                                <option selected="">Select</option>
                                <option value="rider">Rider</option>
                                <option value="client">Client</option>
                            </select>
                        </div>

                        @if ($account_type == 'rider')
                        <div class="separator">
                            <span class="fs-5">Rider</span>
                        </div>
                        @elseif($account_type == 'client')
                        <div class="separator">
                            <span class="fs-5">Client</span>
                        </div>
                        <div class="col-md-12" style="margin-top: 0px;">
                            <label for="inputFirstName" class="form-label">User Type</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="user_type">
                                <option selected="">Select</option>
                                <option value="student">Student</option>
                                <option value="school_staff">School Staff</option>
                                <option value="city_hall_employee">City Hall Employee</option>
                                <option value="city_hall_client">City Hall Client</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        @endif

                        @if ($account_type == 'client')

                        @endif

                        <div class="col-md-4">
                            <label for="inputFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="inputFirstName" data-ddg-inputtype="identities.first_name" wire:model="first_name">
                        </div>
                        <div class="col-md-4">
                            <label for="inputMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="inputMiddleName" data-ddg-inputtype="identities.middle_name" wire:model="middle_name">
                        </div>
                        <div class="col-md-4">
                            <label for="inputLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="inputLastName" data-ddg-inputtype="identities.last_name" wire:model="last_name">
                        </div>
                        <div class="col-md-3">
                            <label for="inputAddress" class="form-label">Ext. Name</label>
                            <select class="form-select @error('extensionName') is-invalid @enderror" id="extensionName" aria-label="extensionName" wire:model="ext_name">
                                <option value="" {{ old('extensionName') ? '' : 'selected' }}>Select</option>
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
                        </div>
                        <div class="col-md-3">
                            <label for="inputSex" class="form-label">Sex</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="sex">
                                <option selected="">Select</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputContactNumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="inputContactNumber" data-ddg-inputtype="identities.contactNumber" wire:model="contactNumber">
                        </div>
                        <div class="col-md-4">
                            <label for="inputAddress" class="form-label">Barangay</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="id_barangay">
                                <option selected="">Select</option>
                                @foreach ($barangay as $item)
                                <option value="{{ $item->id }}">{{ $item->barangay }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="inputAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="inputAddress" data-ddg-inputtype="identities.addressStreet" wire:model="address">
                        </div>

                        @if ($account_type == 'rider')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Organization</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="id_organization">
                                <option selected="">Select</option>
                                @foreach ($organization as $item)
                                <option value="{{ $item->id }}">{{ $item->organization_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @elseif($account_type == 'client')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">School</label>
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="id_school">
                                <option selected="">Select</option>
                                @foreach ($school as $item)
                                <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContactName" class="form-label">Emergency contact name</label>
                            <input type="text" class="form-control" id="inputEmergencyContactName" data-ddg-inputtype="identities.contactNumber" wire:model="guardian_name">
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmergencyContactNumber" class="form-label">Emergency contact Number</label>
                            <input type="text" class="form-control" id="inputEmergencyContactNumber" data-ddg-inputtype="identities.contactNumber" wire:model="guardian_contact_number">
                        </div>
                        @endif

                        @if ($account_type == 'rider')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Email</label>
                            <input type="email" class="form-control" id="inputEmail4" wire:model="email" data-ddg-inputtype="identities.emailAddress" data-ddg-autofill="true" style="background-size: auto 24px !important; background-position: right center !important; background-repeat: no-repeat !important; background-origin: content-box !important; background-image: url(&quot;data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTI4IiBoZWlnaHQ9IjEyOCIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDEyOCAxMjgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8cGF0aCBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Im02NCAxMjhjMzUuMzQ2IDAgNjQtMjguNjU0IDY0LTY0cy0yOC42NTQtNjQtNjQtNjQtNjQgMjguNjU0LTY0IDY0IDI4LjY1NCA2NCA2NCA2NHoiIGZpbGw9IiNkZTU4MzMiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNzMgMTExLjc1YzAtLjUuMTIzLS42MTQtMS40NjYtMy43ODItNC4yMjQtOC40NTktOC40Ny0yMC4zODQtNi41NC0yOC4wNzUuMzUzLTEuMzk3LTMuOTc4LTUxLjc0NC03LjA0LTUzLjM2NS0zLjQwMi0xLjgxMy03LjU4OC00LjY5LTExLjQxOC01LjMzLTEuOTQzLS4zMS00LjQ5LS4xNjQtNi40ODIuMTA1LS4zNTMuMDQ3LS4zNjguNjgzLS4wMy43OTggMS4zMDguNDQzIDIuODk1IDEuMjEyIDMuODMgMi4zNzUuMTc4LjIyLS4wNi41NjYtLjM0Mi41NzctLjg4Mi4wMzItMi40ODIuNDAyLTQuNTkzIDIuMTk1LS4yNDQuMjA3LS4wNDEuNTkyLjI3My41MyA0LjUzNi0uODk3IDkuMTctLjQ1NSAxMS45IDIuMDI3LjE3Ny4xNi4wODQuNDUtLjE0Ny41MTItMjMuNjk0IDYuNDQtMTkuMDAzIDI3LjA1LTEyLjY5NiA1Mi4zNDQgNS42MTkgMjIuNTMgNy43MzMgMjkuNzkyIDguNCAzMi4wMDRhLjcxOC43MTggMCAwIDAgLjQyMy40NjdjOC4xNTYgMy4yNDggMjUuOTI4IDMuMzkyIDI1LjkyOC0yLjEzMnoiIGZpbGw9IiNkZGQiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggZD0ibTc2LjI1IDExNi41Yy0yLjg3NSAxLjEyNS04LjUgMS42MjUtMTEuNzUgMS42MjUtNC43NjQgMC0xMS42MjUtLjc1LTE0LjEyNS0xLjg3NS0xLjU0NC00Ljc1MS02LjE2NC0xOS40OC0xMC43MjctMzguMTg1bC0uNDQ3LTEuODI3LS4wMDQtLjAxNWMtNS40MjQtMjIuMTU3LTkuODU1LTQwLjI1MyAxNC40MjctNDUuOTM4LjIyMi0uMDUyLjMzLS4zMTcuMTg0LS40OTItMi43ODYtMy4zMDUtOC4wMDUtNC4zODgtMTQuNjA1LTIuMTExLS4yNy4wOTMtLjUwNi0uMTgtLjMzNy0uNDEyIDEuMjk0LTEuNzgzIDMuODIzLTMuMTU1IDUuMDcxLTMuNzU2LjI1OC0uMTI0LjI0Mi0uNTAyLS4wMy0uNTg4YTI3Ljg3NyAyNy44NzcgMCAwIDAgLTMuNzcyLS45Yy0uMzctLjA1OS0uNDAzLS42OTMtLjAzMi0uNzQzIDkuMzU2LTEuMjU5IDE5LjEyNSAxLjU1IDI0LjAyOCA3LjcyNmEuMzI2LjMyNiAwIDAgMCAuMTg2LjExNGMxNy45NTIgMy44NTYgMTkuMjM4IDMyLjIzNSAxNy4xNyAzMy41MjgtLjQwOC4yNTUtMS43MTUuMTA4LTMuNDM4LS4wODUtNi45ODYtLjc4MS0yMC44MTgtMi4zMjktOS40MDIgMTguOTQ4LjExMy4yMS0uMDM2LjQ4OC0uMjcyLjUyNS02LjQzOCAxIDEuODEyIDIxLjE3MyA3Ljg3NSAzNC40NjF6IiBmaWxsPSIjZmZmIi8+CiAgICA8cGF0aCBkPSJtODQuMjggOTAuNjk4Yy0xLjM2Ny0uNjMzLTYuNjIxIDMuMTM1LTEwLjExIDYuMDI4LS43MjgtMS4wMzEtMi4xMDMtMS43OC01LjIwMy0xLjI0Mi0yLjcxMy40NzItNC4yMTEgMS4xMjYtNC44OCAyLjI1NC00LjI4My0xLjYyMy0xMS40ODgtNC4xMy0xMy4yMjktMS43MS0xLjkwMiAyLjY0Ni40NzYgMTUuMTYxIDMuMDAzIDE2Ljc4NiAxLjMyLjg0OSA3LjYzLTMuMjA4IDEwLjkyNi02LjAwNS41MzIuNzQ5IDEuMzg4IDEuMTc4IDMuMTQ4IDEuMTM3IDIuNjYyLS4wNjIgNi45NzktLjY4MSA3LjY0OS0xLjkyMS4wNC0uMDc1LjA3NS0uMTY0LjEwNS0uMjY2IDMuMzg4IDEuMjY2IDkuMzUgMi42MDYgMTAuNjgyIDIuNDA2IDMuNDctLjUyMS0uNDg0LTE2LjcyMy0yLjA5LTE3LjQ2N3oiIGZpbGw9IiMzY2E4MmIiLz4KICAgIDxwYXRoIGQ9Im03NC40OSA5Ny4wOTdjLjE0NC4yNTYuMjYuNTI2LjM1OC44LjQ4MyAxLjM1MiAxLjI3IDUuNjQ4LjY3NCA2LjcwOS0uNTk1IDEuMDYyLTQuNDU5IDEuNTc0LTYuODQzIDEuNjE1cy0yLjkyLS44MzEtMy40MDMtMi4xODFjLS4zODctMS4wODEtLjU3Ny0zLjYyMS0uNTcyLTUuMDc1LS4wOTgtMi4xNTguNjktMi45MTYgNC4zMzQtMy41MDYgMi42OTYtLjQzNiA0LjEyMS4wNzEgNC45NDQuOTQgMy44MjgtMi44NTcgMTAuMjE1LTYuODg5IDEwLjgzOC02LjE1MiAzLjEwNiAzLjY3NCAzLjQ5OSAxMi40MiAyLjgyNiAxNS45MzktLjIyIDEuMTUxLTEwLjUwNS0xLjEzOS0xMC41MDUtMi4zOCAwLTUuMTUyLTEuMzM3LTYuNTY1LTIuNjUtNi43MXptLTIyLjUzLTEuNjA5Yy44NDMtMS4zMzMgNy42NzQuMzI1IDExLjQyNCAxLjk5MyAwIDAtLjc3IDMuNDkxLjQ1NiA3LjYwNC4zNTkgMS4yMDMtOC42MjcgNi41NTgtOS44IDUuNjM3LTEuMzU1LTEuMDY1LTMuODUtMTIuNDMyLTIuMDgtMTUuMjM0eiIgZmlsbD0iIzRjYmEzYyIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNTUuMjY5IDY4LjQwNmMuNTUzLTIuNDAzIDMuMTI3LTYuOTMyIDEyLjMyMS02LjgyMiA0LjY0OC0uMDE5IDEwLjQyMi0uMDAyIDE0LjI1LS40MzZhNTEuMzEyIDUxLjMxMiAwIDAgMCAxMi43MjYtMy4wOTVjMy45OC0xLjUxOSA1LjM5Mi0xLjE4IDUuODg3LS4yNzIuNTQ0Ljk5OS0uMDk3IDIuNzIyLTEuNDg4IDQuMzA5LTIuNjU2IDMuMDMtNy40MzEgNS4zOC0xNS44NjUgNi4wNzYtOC40MzMuNjk4LTE0LjAyLTEuNTY1LTE2LjQyNSAyLjExOC0xLjAzOCAxLjU4OS0uMjM2IDUuMzMzIDcuOTIgNi41MTIgMTEuMDIgMS41OSAyMC4wNzItMS45MTcgMjEuMTkuMjAxIDEuMTE5IDIuMTE4LTUuMzIzIDYuNDI4LTE2LjM2MiA2LjUxOHMtMTcuOTM0LTMuODY1LTIwLjM3OS01LjgzYy0zLjEwMi0yLjQ5NS00LjQ5LTYuMTMzLTMuNzc1LTkuMjc5eiIgZmlsbD0iI2ZjMyIgZmlsbC1ydWxlPSJldmVub2RkIi8+CiAgICA8ZyBmaWxsPSIjMTQzMDdlIiBvcGFjaXR5PSIuOCI+CiAgICAgIDxwYXRoIGQ9Im02OS4zMjcgNDIuMTI3Yy42MTYtMS4wMDggMS45ODEtMS43ODYgNC4yMTYtMS43ODYgMi4yMzQgMCAzLjI4NS44ODkgNC4wMTMgMS44OC4xNDguMjAyLS4wNzYuNDQtLjMwNi4zNGE1OS44NjkgNTkuODY5IDAgMCAxIC0uMTY4LS4wNzNjLS44MTctLjM1Ny0xLjgyLS43OTUtMy41NC0uODItMS44MzgtLjAyNi0yLjk5Ny40MzUtMy43MjcuODMxLS4yNDYuMTM0LS42MzQtLjEzMy0uNDg4LS4zNzJ6bS0yNS4xNTcgMS4yOWMyLjE3LS45MDcgMy44NzYtLjc5IDUuMDgxLS41MDQuMjU0LjA2LjQzLS4yMTMuMjI3LS4zNzctLjkzNS0uNzU1LTMuMDMtMS42OTItNS43Ni0uNjc0LTIuNDM3LjkwOS0zLjU4NSAyLjc5Ni0zLjU5MiA0LjAzOC0uMDAyLjI5Mi42LjMxNy43NTYuMDcuNDItLjY3IDEuMTItMS42NDYgMy4yODktMi41NTN6Ii8+CiAgICAgIDxwYXRoIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0ibTc1LjQ0IDU1LjkyYTMuNDcgMy40NyAwIDAgMSAtMy40NzQtMy40NjIgMy40NyAzLjQ3IDAgMCAxIDMuNDc1LTMuNDYgMy40NyAzLjQ3IDAgMCAxIDMuNDc0IDMuNDYgMy40NyAzLjQ3IDAgMCAxIC0zLjQ3NSAzLjQ2MnptMi40NDctNC42MDhhLjg5OS44OTkgMCAwIDAgLTEuNzk5IDBjMCAuNDk0LjQwNS44OTUuOS44OTUuNDk5IDAgLjktLjQuOS0uODk1em0tMjUuNDY0IDMuNTQyYTQuMDQyIDQuMDQyIDAgMCAxIC00LjA0OSA0LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSAtNC4wNS00LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSA0LjA1LTQuMDM3IDQuMDQ1IDQuMDQ1IDAgMCAxIDQuMDUgNC4wMzd6bS0xLjE5My0xLjMzOGExLjA1IDEuMDUgMCAwIDAgLTIuMDk3IDAgMS4wNDggMS4wNDggMCAwIDAgMi4wOTcgMHoiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPC9nPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNjQgMTE3Ljc1YzI5LjY4NSAwIDUzLjc1LTI0LjA2NSA1My43NS01My43NXMtMjQuMDY1LTUzLjc1LTUzLjc1LTUzLjc1LTUzLjc1IDI0LjA2NS01My43NSA1My43NSAyNC4wNjUgNTMuNzUgNTMuNzUgNTMuNzV6bTAgNWMzMi40NDcgMCA1OC43NS0yNi4zMDMgNTguNzUtNTguNzVzLTI2LjMwMy01OC43NS01OC43NS01OC43NS01OC43NSAyNi4zMDMtNTguNzUgNTguNzUgMjYuMzAzIDU4Ljc1IDU4Ljc1IDU4Ljc1eiIgZmlsbD0iI2ZmZiIgZmlsbC1ydWxlPSJldmVub2RkIi8+Cjwvc3ZnPg==&quot;) !important; transition: background !important;">
                        </div>
                        @endif

                        <!-- PASSWORD will be a default password for now. For the sake of the scalability if ever the original process is implement. -->

                </div>
                <div class="my-5 mx-auto" wire:loading>
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: auto;" wire:click="">SAVE</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</div>

@script
<script>
    $wire.on('show_addModal', () => {
        $('#addModal').modal('show');
    });
</script>
@endscript