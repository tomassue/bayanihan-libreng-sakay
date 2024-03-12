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
                                    <input type="date" class="form-control" wire:model="start_date" required>
                                </div>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="end_date" required>
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
                                        <th scope="col">Riders' Name</th>
                                        <th scope="col">Organization</th>
                                        <th scope="col">Total no. of clients served</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riders as $rider)
                                    <tr>
                                        <td>{{$rider->rider_fullname}}</td>
                                        <td>{{$rider->organization}}</td>
                                        <td>
                                            @php
                                            $a = App\Models\EventOrganizationRidersModel::where('id_individual', $rider->id)->pluck('id');
                                            echo $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->count();
                                            @endphp
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

            </div>
        </div>
    </div>
</div>