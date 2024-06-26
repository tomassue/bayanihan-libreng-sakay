<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Organization Report</h1>
                    </div>

                    <div class="col-sm-12 col-lg-9 mb-4">
                        <form wire:submit="search">
                            <div class="row g-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Date</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="start_date" required>
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="end_date" required>
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
                                <a href="{{ route('pdf-org', ['start_date' => $start_date, 'end_date' => $end_date]) }}" target="_blank">
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
                                        <th class="item" scope="col">Organization Name</th>
                                        <th class="item" scope="col">Date established</th>
                                        <th class="item" scope="col">Address</th>
                                        <th class="item" scope="col">Organizations' phone no.</th>
                                        <th class="item" scope="col">Representatives' name</th>
                                        <th class="item" scope="col">Representatives' position</th>
                                        <th class="item" scope="col">Representatives' phone no.</th>
                                        <th class="item" scope="col">No. of events joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organizations as $org)
                                    <tr>
                                        <td>{{strtoupper($org->organization_name)}}</td>
                                        <td>{{$org->date_established}}</td>
                                        <td>{{$org->address}}</td>
                                        <td>{{$org->contact_number}}</td>
                                        <td>{{$org->representative_name}}</td>
                                        <td>{{$org->representative_position}}</td>
                                        <td>{{$org->representative_contact_number}}</td>
                                        <td>
                                            {{
                                            $a = App\Models\EventOrganizationsModel::where('id_organization', $org->org_id)->count()
                                            }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$organizations->links('vendor.livewire.custom-pagination')}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>