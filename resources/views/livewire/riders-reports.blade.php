<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Rider Report</h1>
                    </div>

                    <div class="col-sm-12 col-lg-9 mb-4">
                        <form wire:submit="search">
                            <div class="row g-2 mb-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Date</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="start_date">
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="end_date">
                                </div>
                            </div>

                            <div class="row g-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Organization</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <select class="form-select" aria-label="Default select example" wire:model="query_org">
                                        <option value="" selected="">All</option>
                                        @foreach($organizations as $org)
                                        <option value="{{$org->orgID}}">{{$org->organization_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>

                    <div class="col-sm-12 col-lg-3 text-start">
                        <button type="button" class="btn btn-primary" wire:click="search">Filter</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
                        </form>
                    </div>

                    <div class="col-12">
                        @if($noRecords)
                        <div class="mt-5 mb-5 text-center">
                            <span>No records found.</span>
                        </div>
                        @else
                        <div class="row g-2 mb-2 mt-2">
                            <div class="col-sm-2 text-start">
                                <a href="{{ route('pdf-riders', [
                                'start_date' => $start_date !== '' ? $start_date : 'null', 
                                'end_date' => $end_date !== '' ? $end_date : 'null', 
                                'query_org' => $query_org !== '' ? Crypt::encrypt($query_org) : 'null'
                                ]) }}" target="_blank">
                                    <button type="button" class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M7.25 7h9.5V5c0-2-.75-3-3-3h-3.5c-2.25 0-3 1-3 3v2ZM16 15v4c0 2-1 3-3 3h-2c-2 0-3-1-3-3v-4h8Z" stroke="#d9e3f0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M21 10v5c0 2-1 3-3 3h-2v-3H8v3H6c-2 0-3-1-3-3v-5c0-2 1-3 3-3h12c2 0 3 1 3 3ZM17 15H7M7 11h3" stroke="#d9e3f0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </a>

                                <button type="button" class="btn btn-primary" wire:click="export" wire:loading.wire:loading.attr="disabled">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 11v6l2-2M9 17l-2-2" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M22 10v5c0 5-2 7-7 7H9c-5 0-7-2-7-7V9c0-5 2-7 7-7h5" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M22 10h-4c-3 0-4-1-4-4V2l8 8Z" stroke="#d9e3f0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="col-sm-10">
                                <div class="pagination-info pb-4 text-end">
                                    Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive" wire:loading.class="opacity-50">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="item" scope="col" width="400px">Riders' Name</th>
                                        <th class="item" scope="col">Organization</th>
                                        <th class="item" scope="col" style="text-align: center;">Total no. of <br> events joined</th>
                                        <th class="item" scope="col" style="text-align: center;">Total no. of <br> clients served</th>
                                        <th class="item" scope="col" style="text-align: center;">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riders as $rider)
                                    <tr wire:key="{{ $rider->id }}">
                                        <td>{{$rider->rider_fullname}}</td>
                                        <td>{{$rider->organization}}</td>
                                        <td style="text-align: center;">
                                            @php
                                            echo $c = App\Models\EventOrganizationRidersModel::where('id_individual', $rider->id)->get()->count();
                                            @endphp
                                        </td>
                                        <td style="text-align: center;">
                                            @php
                                            $a = App\Models\EventOrganizationRidersModel::where('id_individual', $rider->id)->pluck('id');
                                            echo $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->count();
                                            @endphp
                                        </td>
                                        <td style="text-align: center;">
                                            <span data-bs-toggle="modal" data-bs-target="#ridersReportModal" style="cursor: pointer;" wire:click="getriderID('{{ $rider->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 22h6c5 0 7-2 7-7V9c0-5-2-7-7-7H9C4 2 2 4 2 9v6c0 5 2 7 7 7ZM15.75 9h-7.5M15.75 15h-7.5" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$riders->links('vendor.livewire.custom-pagination')}}
                        @endif
                    </div>
                </div>
                @include('livewire.report-modals.riders-reports-modal')
            </div>
        </div>
    </div>
</div>