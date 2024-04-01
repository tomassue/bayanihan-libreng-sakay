<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Client Report</h1>
                    </div>

                    <div class="col-sm-12 col-lg-10 mb-4">
                        <form wire:submit="search">
                            <div class="row g-2 mb-2">
                                <label for="inputEmail3" class="col-sm-4 col-md-2 col-lg-1 col-form-label">Date</label>
                                <div class="col-sm-4 col-md-5 col-lg-2">
                                    <input type="date" class="form-control" wire:model="start_date">
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-2">
                                    <input type="date" class="form-control" wire:model="end_date">
                                </div>

                                <label for="inputEmail3" class="col-sm-4 col-md-2 col-lg-2 col-form-label">Account type</label>
                                <div class="col-sm-4 col-md-5 col-lg-4">
                                    <select class="form-select" aria-label="Default select example" wire:model="query_acc_type">
                                        <option value="" selected="">All</option>
                                        <option value="student">Student</option>
                                        <option value="school_staff">School Staff</option>
                                        <option value="city_hall_employee">City Hall Employee</option>
                                        <option value="city_hall_client">City Hall Client</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <label for="inputEvent" class="col-sm-4 col-md-2 col-lg-1 col-form-label">Event</label>
                                <div class="col-sm-4 col-md-5 col-lg-4">
                                    <select class="form-select" aria-label="Default select example" wire:model="query_event">
                                        <option value="" selected="">All</option>
                                        @foreach($event as $item)
                                        <option value="{{$item->id}}">{{$item->event_name . " (" . $item->event_date . ")"}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-2 text-start">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
                        </form>
                    </div>

                    <!-- <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Print</button>
                    </div> -->

                    <div class="col-12">
                        @if($noRecords)
                        <div class="mt-5 mb-5 text-center">
                            <span>No records found.</span>
                        </div>
                        @else
                        <div class="row g-2 mb-2 mt-2">
                            <div class="col-sm-2 text-start">
                                <a href="{{ route('pdf-clients', [
                                    'start_date' => $start_date !== '' ? Crypt::encrypt($start_date) : 'null',
                                    'end_date' => $end_date !== '' ? Crypt::encrypt($end_date) : 'null',
                                    'acct_type' => $query_acc_type !== '' ? Crypt::encrypt($query_acc_type) : 'null',
                                    'query_event' => $query_event !== '' ? Crypt::encrypt($query_event) : 'null'
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

                            <div class="col-sm-10">
                                <div class="pagination-info pb-4 text-end">
                                    Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="item" scope="col">Client</th>
                                        <th class="item" scope="col">Event</th>
                                        <th class="item" scope="col">Date</th>
                                        <th class="item" scope="col">Location</th>
                                        <th class="item" scope="col">Destination</th>
                                        <th class="item" scope="col">Rider</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr>
                                        <td>{{$client->client_fullname}}</td>
                                        <td>{{$client->event_name}}</td>
                                        <td>{{$client->event_date}}</td>
                                        <td>{{ucfirst($client->event_location)}}</td>
                                        <td>{{ucfirst($client->destination)}}</td>
                                        <td>{{ucfirst($client->rider_fullname)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$clients->links('vendor.livewire.custom-pagination')}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>