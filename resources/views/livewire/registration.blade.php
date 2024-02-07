<div>
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

                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageOne">
                                            <div class="card-body" @if( $filter=='' || $filter=='one' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='one' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">REGISTERED {{ Auth::user()->user_id !== 'ADMIN' ? 'MEMBERS' : 'ORGANIZATION' }}</h1>
                                                <h6 class=" text-center">
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
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageTwo">
                                            <div class="card-body" @if( $filter=='' || $filter=='two' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='two' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">FOR APPROVAL</h1>
                                                <h6 class="text-center">
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

                                    @if(Auth::user()->user_id == 'ADMIN')
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageThree">
                                            <div class="card-body" @if( $filter=='' || $filter=='three' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='three' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">EVENT REGISTRATION</h1>
                                                <h6 class="text-center">
                                                    {{ App\Models\EventModel::where('status', 0)
                                                    ->where('tag', 0)
                                                    ->count() }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- <button wire:click="$refresh">Refresh</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($filter == '' || $filter == 'one')

            @if(Auth::user()->user_id !== 'ADMIN') <!-- If NOT Admin -->
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Rider" wire:model.live.debounce.300ms="search_one">
                </div>
                @if($noRecordsRegisteredMembers)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else

                <div class="col text-center table-responsive">

                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageRegisteredMembers }} out of {{ $totalPagesRegisteredMembers }}, Total Records: {{ $totalRecordsRegisteredMembers }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">IS ACTIVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registered_members as $reg_members)
                            <tr>
                                <th scope="row">{{ $reg_members['last_name'] . ', ' . $reg_members['first_name'] . ($reg_members['middle_name'] ? ' ' . $reg_members['middle_name'] : '') . ($reg_members['ext_name'] ? ' ' . $reg_members['middle_name'] . '.' : '') }}</th>
                                <td>{{ $reg_members['contact_number'] }}</td>
                                <td>{{ $reg_members['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editModal">ACTIVE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $registered_members->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @else <!-- If ADMIN -->
            <div class="row mx-5 mt-4 mb-4">

                <div class="input-group mb-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Organization" wire:model.live.debounce.300ms="search_one">
                </div>

                @if($noRecordsOne)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else

                <div class="col text-center table-responsive">

                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageOne }} out of {{ $totalPagesOne }}, Total Records: {{ $totalRecordsOne }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($org_one as $orgone)
                            <tr wire:key="{{ $orgone['id'] }}">
                                <th scope="row">{{ $orgone['organization_name'] }}</th>
                                <td>{{ $orgone['contact_number'] }}</td>
                                <td>{{ $orgone['address'] }}</td>
                                <td>
                                    <a href="/registration/organization-details/{{ $orgone['id'] }}"><img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $org_one->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @endif

            @elseif($filter == 'two')

            @if(Auth::user()->user_id !== 'ADMIN') <!-- If NOT Admin -->
            <div class="row mx-5 mt-4 mb-4">

                <div class="pagination-info my-2 text-end">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn {{ $pagetwo == '' || $pagetwo == 'twopending' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageTwoPending">Pending</button>
                        <button type="button" class="btn {{ $pagetwo == 'twodeclined' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageTwoDeclined">Declined</button>
                    </div>
                </div>

                @if($pagetwo == '' || $pagetwo == 'twopending')
                <div class="input-group mb-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Rider" wire:model.live.debounce.300ms="search_twopending_org">
                </div>
                @if($noRecordsfor_approval_members)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        <div class="row">
                            <div class="col my-auto">
                                Page {{ $currentPagefor_approval_members }} out of {{ $totalPagesfor_approval_members }}, Total Records: {{ $totalRecordsfor_approval_members }}
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($for_approval_members as $for_app_members)
                            <tr wire:key="{{ $for_app_members['user_id'] }}">
                                <th scope="row">{{ $for_app_members['last_name'] . ', ' . $for_app_members['first_name'] . ($for_app_members['middle_name'] ? ' ' . $for_app_members['middle_name'] : '') . ($for_app_members['ext_name'] ? ' ' . $for_app_members['middle_name'] . '.' : '') }}</th>
                                <td>{{ $for_app_members['contact_number'] }}</td>
                                <td>{{ $for_app_members['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#individualModal" wire:click="confirmApproveMember('{{ $for_app_members['user_id'] }}')">APPROVE</span>
                                    <span class="me-1" style="font-weight: bolder; color: #BF0000; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#individualModal" wire:click="confirmDeclineMember('{{ $for_app_members['user_id'] }}')">DECLINE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $for_approval_members->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @elseif($pagetwo == 'twodeclined')
                <div class="input-group mb-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Rider" wire:model.live.debounce.300ms="search_twodeclined_org">
                </div>
                @if($noRecordsdeclined_members)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        <div class="row">
                            <div class="col my-auto">
                                Page {{ $currentPagedeclined_members }} out of {{ $totalPagesdeclined_members }}, Total Records: {{ $totalRecordsdeclined_members    }}
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">IS ACTIVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($declined_members as $dec_members)
                            <tr wire:key="{{ $dec_members['user_id'] }}">
                                <th scope="row">{{ $dec_members['last_name'] . ', ' . $dec_members['first_name'] . ($dec_members['middle_name'] ? ' ' . $dec_members['middle_name'] : '') . ($dec_members['ext_name'] ? ' ' . $dec_members['middle_name'] . '.' : '') }}</th>
                                <td>{{ $dec_members['contact_number'] }}</td>
                                <td>{{ $dec_members['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#individualModal" wire:click="confirmApproveMember('{{ $dec_members['user_id'] }}')">APPROVE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $declined_members->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @endif
            </div>
            @else <!-- If Admin -->
            <div class="row mx-5 mt-4 mb-4">

                <div class="pagination-info my-2 text-end">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn {{ $pagetwo == '' || $pagetwo == 'twopending' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageTwoPending">Pending</button>
                        <button type="button" class="btn {{ $pagetwo == 'twodeclined' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageTwoDeclined">Declined</button>
                    </div>
                </div>

                @if($pagetwo == '' || $pagetwo == 'twopending')
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Organization" wire:model.live.debounce.300ms="search_twopending_admin">
                </div>
                @if($noRecords)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        <div class="row">
                            <div class="col my-auto">
                                Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($org_two as $orgtwo)
                            <tr wire:key="{{ $orgtwo['user_id'] }}">
                                <th scope="row">{{ $orgtwo['organization_name'] }}</th>
                                <td>{{ $orgtwo['contact_number'] }}</td>
                                <td>{{ $orgtwo['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal" wire:click="confirmApproveOrg('{{ $orgtwo['user_id'] }}')">APPROVE </span>
                                    <span class="ms-1" style="font-weight: bolder; color: #BF0000; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal" wire:click="confirmDeclineOrg('{{ $orgtwo['user_id'] }}')">DECLINE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $org_two->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @elseif($pagetwo == 'twodeclined')
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Organization" wire:model.live.debounce.300ms="search_twodeclined_admin">
                </div>
                @if($noRecordsOrgDeclined)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        <div class="row">
                            <div class="col my-auto">
                                Page {{ $currentPageOrgDeclined }} out of {{ $totalPagesOrgDeclined }}, Total Records: {{ $totalRecordsOrgDeclined }}
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($org_declined as $orgdeclined)
                            <tr wire:key="{{ $orgdeclined['user_id'] }}">
                                <th scope="row">{{ $orgdeclined['organization_name'] }}</th>
                                <td>{{ $orgdeclined['contact_number'] }}</td>
                                <td>{{ $orgdeclined['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal2" wire:click="confirmApproveOrg2('{{ $orgdeclined['user_id'] }}')">APPROVE </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $org_declined->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @endif
            </div>
            @endif

            @elseif($filter == 'three')

            <div class=" row mx-5 mt-4 mb-4">

                <div class="pagination-info my-2 text-end">
                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                        <button type="button" class="btn {{ $pagethree == '' || $pagethree == 'threepending' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageThreePending">Pending</button>
                        <button type="button" class="btn {{ $pagethree == 'threedeclined' ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="pageThreeDeclined">Declined</button>
                    </div>
                </div>

                @if($pagethree == '' || $pagethree == 'threepending')
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Event" wire:model.live.debounce.300ms="search_threepending_admin">
                </div>
                @if($noRecordsEvents)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else

                <div class="col text-center table-responsive">

                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageEvents }} out of {{ $totalPagesEvents }}, Total Records: {{ $totalRecordsEvents }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr wire:key="{{ $event['id'] }}">
                                <th scope="row">{{ $event['event_name'] }}</th>
                                <td>Organization ID</td>
                                <td>No. of Riders</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal3" wire:click="confirmApproveEvent('{{ $event['id'] }}')">APPROVE </span>
                                    <span class="ms-1" style="font-weight: bolder; color: #BF0000; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal3" wire:click="confirmDeclineEvent('{{ $event['id'] }}')">DECLINE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $events->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @elseif($pagethree == 'threedeclined')
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Event" wire:model.live.debounce.300ms="search_threedeclined_admin">
                </div>
                @if($noRecordsEventsDeclined)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else

                <div class="col text-center table-responsive">

                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageEventsDeclined }} out of {{ $totalPagesEventsDeclined }}, Total Records: {{ $totalRecordsEventsDeclined }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events_declined as $eventdeclined)
                            <tr wire:key="{{ $eventdeclined['id'] }}">
                                <th scope="row">{{ $eventdeclined['event_name'] }}</th>
                                <td>Organization ID</td>
                                <td>No. of Riders</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal3" wire:click="confirmApproveEvent('{{ $eventdeclined['id'] }}')">APPROVE </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $events_declined->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @endif
            </div>

            @endif

        </div>
    </div>

    <!-- CONFIRMATION MESSAGE -->
    <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="confirmModalLabel">Warning!</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <h4>Are you sure you want to proceed?</h4>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 100px;" wire:click="{{ $approve ? 'approveOrg' : 'declineOrg' }}('{{ $userID }}')">{{ $approve ? 'Approve' : 'Decline' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMATION MESSAGE for the declined organization -->
    <div wire:ignore.self class="modal fade" id="confirmModal2" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="confirmModalLabel">Warning!</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <h4>Are you sure you want to proceed?</h4>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 100px;" wire:click="approveOrg2('{{ $userID }}')">Approve</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMATION MESSAGE for the approving events -->
    <div wire:ignore.self class="modal fade" id="confirmModal3" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="confirmModalLabel">Warning!</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <h4>Are you sure you want to proceed?</h4>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 100px;" wire:click="{{ $approve ? 'approveEvent' : 'declineEvent' }}('{{ $eventID }}')">{{ $approve ? 'Approve' : 'Decline' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONFIRMATION MESSAGE for the individuals -->
    <div wire:ignore.self class="modal fade" id="individualModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="confirmModalLabel">Warning!</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <h4>Are you sure you want to proceed?</h4>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 100px;" wire:click="{{ $approve ? 'approveMember' : 'declineMember' }}('{{ $individualID }}')">{{ $approve ? 'Approve' : 'Decline' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@script
<script>
    // Back in the component, we dispatched an event called 'close-modal'. This code will listen to that dispatch and execute the script.
    $wire.on('close-modal', () => {
        $('#confirmModal').modal('hide');
    });

    $wire.on('close-modal2', () => {
        $('#confirmModal2').modal('hide');
    });

    $wire.on('close-modal3', () => {
        $('#confirmModal3').modal('hide');
    });

    $wire.on('close-individualModal', () => {
        $('#individualModal').modal('hide');
    });
</script>
@endscript