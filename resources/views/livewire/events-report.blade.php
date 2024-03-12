<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Event Report</h1>
                    </div>

                    <div class="col-sm-12 col-lg-9 mb-4">
                        <form wire:submit="search">
                            <div class="row g-2 mb-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Date</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="start_date" required>
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="end_date" required>
                                </div>
                            </div>

                            <div class="row g-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Account type</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
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
                    </div>

                    <div class="col-sm-12 col-lg-3 text-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
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
                                <a href="{{ route('pdf-events') }}" target="_blank">
                                    <button type="button" class="btn btn-primary" wire:click="printPDF">Print</button>
                                </a>
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
                                        <th scope="col">Client</th>
                                        <th scope="col">Event</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Destination</th>
                                        <th scope="col">Rider</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients_transact as $client_trans)
                                    <tr>
                                        <td>{{$client_trans->client_fullname}}</td>
                                        <td>{{$client_trans->event_name}}</td>
                                        <td>{{$client_trans->event_date}}</td>
                                        <td>{{ucfirst($client_trans->event_location)}}</td>
                                        <td>{{ucfirst($client_trans->destination)}}</td>
                                        <td>{{ucfirst($client_trans->rider_fullname)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$clients_transact->links('vendor.livewire.custom-pagination')}}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>