<div>
    <div class="col-12">
        <div class="card border border-secondary">

            <div class="row mx-5 mt-4">
                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-header h-50" style="background-color: #228B22; border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important; color: white; text-shadow: 1px 1px 0 black;">EVENTS</h1>
                                            </div>
                                            <div class="card-body" style="background-color: #228B22;">
                                                <h6 class="text-center text-white fs-1" style="text-shadow: 1px 1px 0 black;">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                                                        ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\EventModel::all()->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-header h-50" style="background-color: #2E8B57; border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important; color: white; text-shadow: 1px 1px 0 black;">STUDENTS</h1>
                                            </div>
                                            <div class="card-body" style="background-color: #2E8B57;">
                                                <h6 class="text-center text-white fs-1" style="text-shadow: 1px 1px 0 black;">
                                                    {{
                                                        App\Models\ClientInformationModel::where('user_type', 'student')
                                                        ->count()
                                                    }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-header h-50" style="background-color: #50C878; border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important; color: white; text-shadow: 1px 1px 0 black;">STAFFS</h1>
                                            </div>
                                            <div class="card-body" style="background-color: #50C878;">
                                                <h6 class="text-center text-white fs-1" style="text-shadow: 1px 1px 0 black;">
                                                    {{
                                                        App\Models\ClientInformationModel::where('user_type', 'staff')
                                                        ->count()
                                                    }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-header h-50" style="background-color: #98FF98; border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important; color: white; text-shadow: 1px 1px 0 black;">OTHER CLIENTS</h1>
                                            </div>
                                            <div class="card-body" style="background-color: #98FF98;">
                                                <h6 class="text-center text-white fs-1" style="text-shadow: 1px 1px 0 black;">
                                                    {{
                                                        App\Models\ClientInformationModel::where('user_type', 'other')
                                                        ->count()
                                                    }}
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

            <div class="row mx-5 mt-4">
                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-header h-50" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">REGISTERED {{ Auth::user()->user_id !== 'ADMIN' ? 'MEMBERS' : 'ORGANIZATION' }}</h1>
                                            </div>
                                            <div class="card-body">
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
                                            <div class="card-header h-50" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">FOR APPROVAL</h1>
                                            </div>
                                            <div class="card-body">
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
                                            <div class="card-header h-50" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">RIDERS</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
                                                        ->join('users', 'individual_information.user_id', 'users.user_id')
                                                        ->where('status', 1)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\IndividualInformationModel::join('users', 'individual_information.user_id', 'users.user_id')
                                                        ->where('status', 1)
                                                        ->count() }}
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

            @if(Auth::user()->user_id !== 'ADMIN')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">TYPE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($individual_information as $indi_info)
                            <tr wire:key="{{ $indi_info->user_id }}">
                                <th scope="row">{{ $indi_info['last_name'] . ', ' . $indi_info['first_name'] . ($indi_info['middle_name'] ? ' ' . $indi_info['middle_name'] : '') . ($indi_info['ext_name'] ? ' ' . $indi_info['middle_name'] . '.' : '') }}</th>
                                <td>{{ $indi_info->address }}</td>
                                <!-- I used the syntax below since we are accessing data to access the property id_account_type of the related User model through the relationship defined in the OrganizationInformationModel -->
                                <td>{{ $indi_info->account_type_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NAME</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">TYPE</th>
                                <th scope="col">RIDER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organization_information as $org_info)
                            <tr wire:key="{{ $org_info->user_id }}">
                                <th scope="row">{{ $org_info->organization_name }}</th>
                                <td>{{ $org_info->address }}</td>
                                <!-- I used the syntax below since we are accessing data to access the property id_account_type of the related User model through the relationship defined in the OrganizationInformationModel -->
                                <td>{{ $org_info->account_type_name }}</td>
                                <td>
                                    {{
                                        App\Models\IndividualInformationModel::where('id_organization', $org_info->id)
                                        ->count()
                                    }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- <div class="row m-5">

        <div class="col m-3">
            <div class="card info-card sales-card border border-secondary" style="border-bottom-width: 0px; margin-bottom: 0px;">
                <div class=" card-body text-center">
                    <h1 class="card-title text-center fw-bold fs-3" style="color: white; -webkit-text-stroke: .01px black;">EVENTS</h1>
                    <h6>145</h6>
                </div>
            </div>
        </div>

        <div class="col m-3">
            <div class="card info-card sales-card border border-secondary" style="border-bottom-width: 0px; margin-bottom: 0px;">
                <div class=" card-body text-center">
                    <h1 class="card-title text-center fw-bold fs-3" style="color: white; -webkit-text-stroke: .01px black;">EVENTS</h1>
                    <h6>145</h6>
                </div>
            </div>
        </div>

        <div class="col m-3">
            <div class="card info-card sales-card border border-secondary" style="border-bottom-width: 0px; margin-bottom: 0px;">
                <div class=" card-body text-center">
                    <h1 class="card-title text-center fw-bold fs-3" style="color: white; -webkit-text-stroke: .01px black;">EVENTS</h1>
                    <h6>145</h6>
                </div>
            </div>
        </div>

        <div class="col m-3">
            <div class="card info-card sales-card border border-secondary" style="border-bottom-width: 0px; margin-bottom: 0px;">
                <div class=" card-body text-center">
                    <h1 class="card-title text-center fw-bold fs-3" style="color: white; -webkit-text-stroke: .01px black;">EVENTS</h1>
                    <h6>145</h6>
                </div>
            </div>
        </div>

    </div> -->