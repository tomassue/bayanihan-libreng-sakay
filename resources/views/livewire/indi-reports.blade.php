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
                                        <th scope="col">Transaction history</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riders as $item)
                                    <tr wire:key="{{ $item->id }}">
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
                                        <td>
                                            <span data-bs-toggle="modal" data-bs-target="#indiReportModal" style="cursor: pointer;" wire:click="getindiID('{{ $item->id }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 22h6c5 0 7-2 7-7V9c0-5-2-7-7-7H9C4 2 2 4 2 9v6c0 5 2 7 7 7ZM15.75 9h-7.5M15.75 15h-7.5" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $riders->links('vendor.livewire.custom-pagination') }}
                        </div>
                    </div>
                </div>
                @include('livewire.report-modals.indi-reports-modal')
            </div>
        </div>
    </div>
</div>