<!-- ridersReportModal -->

<div wire:ignore.self class="modal fade" id="ridersReportModal" tabindex="-1" aria-labelledby="ridersReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="ridersReportModalLabel">Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                @if($eventsjoined->count() == 0)
                <div class="row mb-3 fw-light text-center my-4">
                    <span>No records.</span>
                </div>
                @else
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Event</th>
                                <th scope="col">Date</th>
                                <th scope="col">No. of client served</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($riderID)
                            @php $no = 1; @endphp
                            @foreach($eventsjoined as $item)
                            <tr wire:key="{{ $item->id }}">
                                <th scope="row">{{ $no }}</th>
                                <td>{{ $item->event }}</td>
                                <td>{{ $item->date }}</td>
                                <td>
                                    @php
                                    echo $a = App\Models\TransactionModel::where('id_event_organization_riders', $item->id)->count();
                                    @endphp
                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary fw-bolder mt-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ridersReportModal end -->