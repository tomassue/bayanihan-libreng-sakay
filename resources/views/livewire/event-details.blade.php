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
                    <a href="/events"><button type="button" class="btn btn-primary"><i class="bi bi-arrow-bar-left"></i> Go Back</button></a>
                </div>

                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body" style="background-color: #2E8B57; color: #FFFFFF;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" style="font-size: 23px; font-weight: 1000 !important;">TOTAL NO. OF EVENTS</h1>
                                                <h6 class="text-center">
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
                                    @if(Auth::user()->user_id !== 'ADMIN')
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">LIST OF EVENTS</h1>
                                                <h6 class="text-center">
                                                    {{ App\Models\EventModel::where('status', 1)
                                                        ->whereNotExists(function ($query) {
                                                            $query->select(DB::raw(1))
                                                                ->from('event_organizations')
                                                                ->whereRaw('event_organizations.id_event = events.id');
                                                            $query->whereRaw('event_organizations.id_organization = ?', [Auth::user()->organization_information->id]);
                                                        })
                                                        ->count() }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">ON-GOING</h1>
                                                <h6 class="text-center">
                                                    @if(Auth::user()->user_id !== 'ADMIN')
                                                    {{ App\Models\EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                                                        ->join('events', 'events.id', '=', 'event_organizations.id_event')
                                                        ->where('events.tag', 0)
                                                        ->count() }}
                                                    @else
                                                    {{ App\Models\EventModel::where('tag', 0)->count() }}
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary">
                                            <div class="card-body">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">DONE</h1>
                                                <h6 class="text-center">
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

            <div class="row mx-5 mt-4 mb-4">
                @if(Auth::user()->user_id !== 'ADMIN')
                @if($noRecordsorg_event_details)
                <div class="pagination-info pt-4">
                    <p class="text-center">No records found.</p>
                </div>
                @else
                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $currentPageorg_event_details }} out of {{ $totalPagesorg_event_details }}, Total Records: {{ $totalRecordsorg_event_details }}
                    </div>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">EVENT'S NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">RIDER'S NAME</th>
                                <th scope="col">CONTACT NO.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                            </tr>
                            @foreach($org_event_details as $orgeventdetails)
                            <tr style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;" wire:key="{{ $orgeventdetails['id'] }}">
                                <th scope="row">{{ $orgeventdetails['event_name'] }}</th>
                                <td>{{ $orgeventdetails['event_date'] }}</td>
                                <td>{{ $orgeventdetails['last_name'] . ', ' . $orgeventdetails['first_name'] . ($orgeventdetails['middle_name'] ? ' ' . $orgeventdetails['middle_name'] : '') . ($orgeventdetails['ext_name'] ? ' ' . $orgeventdetails['middle_name'] . '.' : '') }}</td>
                                <td>{{ $orgeventdetails['indi_contact_number'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $org_event_details->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @else
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
                                <th scope="col">EVENT'S NAME</th>
                                <th scope="col">RIDER'S NAME</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">ORGANIZATION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                            </tr>
                            @foreach($event as $event_detail)
                            <tr style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
                                <th scope="row">{{ $event_detail['event_name'] }}</th>
                                <td>{{ $event_detail['last_name'] . ', ' . $event_detail['first_name'] . ($event_detail['middle_name'] ? ' ' . $event_detail['middle_name'] : '') . ($event_detail['ext_name'] ? ' ' . $event_detail['middle_name'] . '.' : '') }}</td>
                                <td>###</td>
                                <td>{{ $event_detail['organization_name'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $event->links('vendor.livewire.custom-pagination') }}
                </div>
                @endif
                @endif
            </div>

        </div>
    </div>
</div>