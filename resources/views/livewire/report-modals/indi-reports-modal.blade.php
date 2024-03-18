<!-- indiReportModal -->

<div wire:ignore.self class="modal fade" id="indiReportModal" tabindex="-1" aria-labelledby="indiReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="indiReportModalLabel">Transaction History</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                @if($riderTransactions->count() == 0)
                <div class="text-center my-2">
                    <span>No records.</span>
                </div>
                @else
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Event</th>
                            <th scope="col">Date</th>
                            <th scope="col">Client Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($riderTransactions as $item)
                        <tr>
                            <th scope="row">{{$no}}</th>
                            <td>{{$item->event}}</td>
                            <td>{{$item->date}}</td>
                            <td>{{$item->client_fullname}}</td>
                        </tr>
                        @php $no++ @endphp
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary fw-bolder mt-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- indiReportModal end -->