<div>

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
                <div class="col">
                    <div class="card h-70 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row justify-content-center">

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer;" wire:click="pageOne">
                                            <div class="card-header h-100" @if( $filter=='' || $filter=='one' ) style="background-color: #2E8B57; border: unset;" @else style="border: unset;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='one' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">TOTAL NO. OF EVENTS</h1>
                                            </div>
                                            <div class="card-body" @if( $filter=='' || $filter=='one' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                                                        ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                                        ->where('event_organizations.status', 1)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\EventModel::all()->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @if(Auth::user()->user_id !== 'ADMIN')
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;" wire:click="pageFour">
                                            <div class="card-header h-100" @if( $filter=='' || $filter=='four' ) style="background-color: #2E8B57; border: unset;" @else style="border: unset;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='four' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">LIST OF EVENTS</h1>
                                            </div>
                                            <div class="card-body" @if( $filter=='' || $filter=='four' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h6 class="text-center fs-1">
                                                    {{ $listOfEvents->count() }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;" wire:click="pageTwo">
                                            <div class="card-header h-100" @if( $filter=='' || $filter=='two' ) style="background-color: #2E8B57; border: unset;" @else style="border: unset;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='two' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">UPCOMING</h1>
                                            </div>
                                            <div class="card-body" @if( $filter=='' || $filter=='two' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                                                    ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                                    ->where('events.tag', 0)
                                                    ->where('event_organizations.status', 1)
                                                    ->count() }}
                                                    @else
                                                    {{ App\Models\EventModel::where('tag', 0)->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;" wire:click="pageThree">
                                            <div class="card-header h-100" @if( $filter=='' || $filter=='three' ) style="background-color: #2E8B57; border: unset;" @else style="border: unset;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='three' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">DONE</h1>
                                            </div>
                                            <div class="card-body" @if( $filter=='' || $filter=='three' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                                                        ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                                        ->where('events.tag', 1)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\EventModel::where('tag', 1)->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($filter == '' || $filter == 'one') <!-- This should show all ongoing and done events -->

            @if(Auth::user()->user_id !== 'ADMIN')
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_totalNoOfEvents_org">
                </div>
                @if($noRecordsOnetotalNoOfEvents_org)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageOnetotalNoOfEvents_org }} out of {{ $totalPagesOnetotalNoOfEvents_org }}, Total Records: {{ $totalRecordsOnetotalNoOfEvents_org }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalNoOfEvents_org as $total_no_of_events_org)
                            <tr wire:key="{{ $total_no_of_events_org['event_organizations_id'] }}">
                                <th scope="row">{{ $total_no_of_events_org['event_name'] }}</th>
                                <td>{{ $total_no_of_events_org['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $total_no_of_events_org['events_id'])
                                    ->where('id_organization', [Auth::user()->organization_information->id])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    {{
                                        App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                                        ->where('id_event_organization', $total_no_of_events_org['event_organizations_id'])
                                        ->count();
                                    }}
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $total_no_of_events_org['event_organizations_id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $totalNoOfEvents_org->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @else
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_totalNoOfEvents_admin">
                </div>
                @if($noRecordstotalNoOfEvents)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPagetotalNoOfEvents }} out of {{ $totalPagestotalNoOfEvents }}, Total Records: {{ $totalRecordstotalNoOfEvents }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($totalNoOfEvents as $total_no_of_events)
                            <tr wire:key="{{ $total_no_of_events['id'] }}">
                                <th scope="row">{{ $total_no_of_events['event_name'] }}</th>
                                <td>{{ $total_no_of_events['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $total_no_of_events['id'])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    // We want to get all records on a specific column that satisfies the where condition through pluck('column_name')
                                    $two = App\Models\EventOrganizationsModel::where('id_event', $total_no_of_events['id'])
                                    ->pluck('id');

                                    // whereIn() method is used to check if the 'id_event_organization' column is in the array of values in $two.
                                    echo App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organizations.id', 'event_organization_riders.id_event_organization')
                                    ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                    ->select('events.id AS id_event', 'events.*', 'event_organizations.id AS id_event_organization', 'event_organizations.*', 'event_organization_riders.id AS id_event_organization_riders', 'event_organization_riders.*')
                                    ->whereIn('id_event_organization', $two)
                                    ->count();
                                    @endphp
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $total_no_of_events['id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $totalNoOfEvents->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                <div class="text-end mt-2">
                    @if(Auth::user()->user_id == 'ADMIN')
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#eventSaveModal">ADD EVENT</button>
                    @endif
                </div>
            </div>
            @endif

            @elseif($filter == 'two') <!-- Should show only ongoing events-->

            @if(Auth::user()->user_id !== 'ADMIN')
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_onGoingEvents_org">
                </div>
                @if($noRecordsOneonGoingEvents_org)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageOneonGoingEvents_org }} out of {{ $totalPagesOneonGoingEvents_org }}, Total Records: {{ $totalRecordsOneonGoingEvents_org }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onGoingEvents_org as $ongoing_events_org)
                            <tr wire:key="{{ $ongoing_events_org['id'] }}">
                                <th scope="row">{{ $ongoing_events_org['event_name'] }}</th>
                                <td>{{ $ongoing_events_org['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $ongoing_events_org['id'])
                                    ->where('id_organization', [Auth::user()->organization_information->id])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    {{
                                        App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                                        ->where('id_event_organization', $ongoing_events_org['event_organizations_id'])
                                        ->count();
                                    }}
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $ongoing_events_org['event_organizations_id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $onGoingEvents_org->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @else
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_onGoingEvents_admin">
                </div>
                @if($noRecordstotalNoOfEvents)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageonGoingEvents }} out of {{ $totalPagesonGoingEvents }}, Total Records: {{ $totalRecordsonGoingEvents }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($onGoingEvents as $ongoing_events)
                            <tr wire:key="{{ $ongoing_events['id'] }}">
                                <th scope="row">{{ $ongoing_events['event_name'] }}</th>
                                <td>{{ $ongoing_events['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $ongoing_events['id'])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    // We want to get all records on a specific column that satisfies the where condition through pluck('column_name')
                                    $two = App\Models\EventOrganizationsModel::where('id_event', $ongoing_events['id'])
                                    ->pluck('id');

                                    // whereIn() method is used to check if the 'id_event_organization' column is in the array of values in $two.
                                    echo App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organizations.id', 'event_organization_riders.id_event_organization')
                                    ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                    ->select('events.id AS id_event', 'events.*', 'event_organizations.id AS id_event_organization', 'event_organizations.*', 'event_organization_riders.id AS id_event_organization_riders', 'event_organization_riders.*')
                                    ->whereIn('id_event_organization', $two)
                                    ->count();
                                    @endphp
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $ongoing_events['id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $onGoingEvents->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @endif

            @elseif($filter == 'three') <!-- Should show only those that are already done -->

            @if(Auth::user()->user_id !== 'ADMIN')
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_doneEvents_org">
                </div>
                @if($noRecordsOnedoneEvents_org)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageOnedoneEvents_org }} out of {{ $totalPagesOnedoneEvents_org }}, Total Records: {{ $totalRecordsOnedoneEvents_org }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doneEvents_org as $done_Events_org)
                            <tr wire:key="{{ $done_Events_org['id'] }}">
                                <th scope="row">{{ $done_Events_org['event_name'] }}</th>
                                <td>{{ $done_Events_org['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $done_Events_org['id'])
                                    ->where('id_organization', [Auth::user()->organization_information->id])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    {{
                                        App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                                        ->where('id_event_organization', $done_Events_org['event_organizations_id'])
                                        ->count();
                                    }}
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $done_Events_org['event_organizations_id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $doneEvents_org->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @else
            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_doneEvents_admin">
                </div>
                @if($noRecordsdoneEvents)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPagedoneEvents }} out of {{ $totalPagesdoneEvents }}, Total Records: {{ $totalRecordsdoneEvents }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doneEvents as $done_Events)
                            <tr wire:key="{{ $done_Events['id'] }}">
                                <th scope="row">{{ $done_Events['event_name'] }}</th>
                                <td>{{ $done_Events['event_date'] }}</td>
                                <td>
                                    @php
                                    $one = App\Models\EventOrganizationsModel::where('id_event', $done_Events['id'])
                                    ->pluck('id');

                                    $onetwo = App\Models\EventOrganizationRidersModel::whereIn('id_event_organization', $one)
                                    ->pluck('id');

                                    $onethree = App\Models\TransactionModel::whereIn('id_event_organization_riders', $onetwo)
                                    ->count();

                                    echo $onethree;
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    // We want to get all records on a specific column that satisfies the where condition through pluck('column_name')
                                    $two = App\Models\EventOrganizationsModel::where('id_event', $done_Events['id'])
                                    ->pluck('id');

                                    // whereIn() method is used to check if the 'id_event_organization' column is in the array of values in $two.
                                    echo App\Models\EventOrganizationRidersModel::join('event_organizations', 'event_organizations.id', 'event_organization_riders.id_event_organization')
                                    ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                    ->select('events.id AS id_event', 'events.*', 'event_organizations.id AS id_event_organization', 'event_organizations.*', 'event_organization_riders.id AS id_event_organization_riders', 'event_organization_riders.*')
                                    ->whereIn('id_event_organization', $two)
                                    ->count();
                                    @endphp
                                </td>
                                <td>
                                    <a href="{{ route('event-details', $done_Events['id']) }}">
                                        <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $doneEvents->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
            </div>
            @endif

            @elseif($filter == 'four')

            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_listOfEvents_org">
                </div>
                @if($noRecordsOnelistOfEvents)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else

                <div class="col text-center table-responsive">

                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageOnelistOfEvents }} out of {{ $totalPagesOnelistOfEvents }}, Total Records: {{ $totalRecordsOnelistOfEvents }}
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listOfEvents as $list_of_events)
                            <tr wire:key="{{ $list_of_events['id'] }}">
                                <th scope="row">{{ $list_of_events['event_name'] }}</th>
                                <td>{{ $list_of_events['event_date'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-success fw-bold mx-auto" style="width: 100px;padding-right: 0px;padding-top: 0px;padding-left: 0px;padding-bottom: 0px;" data-bs-toggle="modal" data-bs-target="#confirmJoinModal" wire:click="confirmJoinEvent('{{ $list_of_events['id'] }}')">JOIN</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-2">
                    @if(Auth::user()->user_id == 'ADMIN')
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#eventSaveModal">ADD EVENT</button>
                    @endif
                </div>
                {{ $listOfEvents->links('vendor.livewire.custom-pagination') }}
                @endif

            </div>

            @endif

        </div>
    </div>
    @include('other-modals')
</div>

@script
<script>
    $wire.on('close-eventSave-Modal', () => {
        $('#eventSaveModal').modal('hide');
    });

    $wire.on('close-confirmJoin-Modal', () => {
        $('#confirmJoinModal').modal('hide');
    });
</script>
@endscript