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

                <div class="col-12 mb-2">
                    <a href="{{ route('registration') }}"><button type="button" class="btn btn-primary"><i class="bi bi-arrow-bar-left"></i> Go Back</button></a>
                </div>

                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class="container">
                                <div class="row">

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body" style="background-color: #2E8B57; color: #FFFFFF;">
                                                <h1 class="card-title text-center h-50" style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" style="font-size: 23px; font-weight: 1000 !important;">REGISTERED {{ Auth::user()->user_id !== 'ADMIN' ? 'MEMBERS' : 'ORGANIZATION' }}</h1>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
                                                        ->join('users', 'individual_information.user_id', 'users.user_id')
                                                        ->where('status', 1)
                                                        ->count() }}
                                                    @else
                                                    {{ $registeredOrganization = App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                                                    ->where('status', 1)
                                                    ->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body">
                                                <h1 class="card-title text-center h-50" style="font-size: 23px; font-weight: 1000 !important;">FOR APPROVAL</h1>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
                                                        ->join('users', 'individual_information.user_id', 'users.user_id')
                                                        ->where('status', 0)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                                                    ->where('status', 0)
                                                    ->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body">
                                                <h1 class="card-title text-center h-50" style="font-size: 23px; font-weight: 1000 !important;">FOR APPROVAL</h1>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
                                                        ->join('users', 'individual_information.user_id', 'users.user_id')
                                                        ->where('status', 0)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
                                                    ->where('status', 0)
                                                    ->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <button wire:click="$refresh">Refresh</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mx-5 mt-4 mb-4">
                @if($noRecords)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
                    </div>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                            </tr>
                            @foreach($individual as $rider)
                            <tr style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
                                <th scope="row">{{ $rider['last_name'] . ', ' . $rider['first_name'] . ($rider['middle_name'] ? ' ' . $rider['middle_name'] : '') . ($rider['ext_name'] ? ' ' . $rider['middle_name'] . '.' : '') }}</th>
                                <td>{{ $rider['contactNumber'] }}</td>
                                <td>{{ $rider['address'] }}</td>
                                <td>
                                    @if($rider['status'] == 0)
                                    <span style="color: #343541;">
                                        Inactive
                                    </span>
                                    @else
                                    <span style="color: #2E8B57;">
                                        Active
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $individual->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>