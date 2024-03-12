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
                                <button type="submit" class="btn btn-primary">Print</button>
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
                                        <th scope="col">Organization Name</th>
                                        <th scope="col">Date established</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Organizations' phone no.</th>
                                        <th scope="col">Representatives' name</th>
                                        <th scope="col">Representatives' position</th>
                                        <th scope="col">Representatives' phone no.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organizations as $org)
                                    <tr>
                                        <td>{{strtoupper($org->organization_name)}}</td>
                                        <td>{{$org->date_established}}</td>
                                        <td>{{$org->address}}</td>
                                        <td>{{$org->representative_name}}</td>
                                        <td>{{$org->representative_position}}</td>
                                        <td>{{$org->representative_contact_number}}</td>
                                        <td>{{$org->contact_number}}</td>
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