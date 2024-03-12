<div>
    <div class="col">
        <div class="card">

            <div class="card-body pt-3">
                <div class="pt-2 pb-5">
                    <h1>Client Report</h1>
                </div>

                <form wire:submit="search">
                    <div class="row mb-4">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Account Type</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" wire:model="query">
                                <option value="" selected="">All</option>
                                <option value="student">Student</option>
                                <option value="school_staff">School Staff</option>
                                <option value="city_hall_employee">City Hall Employee</option>
                                <option value="city_hall_client">City Hall Client</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Filter</button>
                </form>
                <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
            </div>


            <div class="pagination-info pt-5 pb-4 text-start">
                Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Client Name</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">User Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td>{{$client->client_fullname}}</td>
                            <td>{{$client->contactNumber}}</td>
                            <td>{{ucfirst(str_replace("_"," ", $client->user_type))}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{$clients->links('vendor.livewire.custom-pagination')}}
        </div>
    </div>

</div>
</div>