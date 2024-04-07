<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <h1>Riders Report</h1>
                    </div>

                    <div class="col-12">

                        <div class="row g-2 mb-2">
                            <div class="input-group mb-4 mt-4">
                                <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Rider" wire:model.live.debounce.300ms="search_rider">
                            </div>
                        </div>

                        @if($noRecords)

                        <div class="mt-5 mb-5 text-center">
                            <span>No records found.</span>
                        </div>

                        @else

                        <div class="row g-2 mb-2 mt-2">

                            <div class="row g-2 mb-2 mt-2">
                                <div class="col-sm-2 text-start">
                                    <a href="{{ route('pdf-indi', ['search_rider' => $search_rider]) }}" target="_blank">
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
                        </div>


                        <div class="table-responsive" wire:loading.class="opacity-50">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="item" scope="col">Riders Name</th>
                                        <th class="item" scope="col" style="text-align: center;">No. of events<br> joined</th>
                                        <th class="item" scope="col" style="text-align: center;">No. of clients<br> served</th>
                                        <th class="item" scope="col" style="text-align: center;">Transaction <br>history</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riders as $item)
                                    <tr wire:key="{{ $item->id }}">
                                        <td>{{ucfirst($item->rider_fullname)}}</td>
                                        <td style="text-align: center;">
                                            @php
                                            $a = App\Models\EventOrganizationRidersModel::where('id_individual', $item->id)->pluck('id');
                                            echo $a->count();
                                            @endphp
                                        </td>
                                        <td style="text-align: center;">
                                            @php
                                            $b = App\Models\TransactionModel::whereIn('id_event_organization_riders', $a)->pluck('id');
                                            echo $b->count();
                                            @endphp
                                        </td>
                                        <td style="text-align: center;">
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
                        @endif
                    </div>
                </div>
                @include('livewire.report-modals.indi-reports-modal')
            </div>
        </div>
    </div>
</div>