<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Riders Report</h1>
                    </div>

                    <div class="col-12">

                        <!-- <div class="mt-5 mb-5 text-center">
                            <span>No records found.</span>
                        </div> -->

                        <div class="row g-2 mb-2 mt-2">

                            <div class="col-sm-12">
                                <div class="pagination-info pb-4 text-end">
                                    Page {{ $currentPage }} out of {{ $totalPages }}, Total Records: {{ $totalRecords }}
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Riders Name</th>
                                        <th scope="col">No. of events joined</th>
                                        <th scope="col">No. of clients served</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riders as $item)
                                    <tr>
                                        <td>{{ucfirst($item->rider_fullname)}}</td>
                                        <td>
                                            @php
                                            $a = App\Models\EventOrganizationRidersModel::where('id_individual', $item->id)->pluck('id');
                                            echo $a->count();
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                            $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->pluck('id');
                                            echo $b->count();
                                            @endphp
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $riders->links('vendor.livewire.custom-pagination') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>