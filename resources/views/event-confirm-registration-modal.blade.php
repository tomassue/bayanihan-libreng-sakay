<!-- CONFIRMATION MESSAGE for the approving organizations to join the events -->
<div wire:ignore.self class="modal fade" id="confirmApproveEvent" tabindex="-1" aria-labelledby="confirmApproveEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="confirmApproveEventLabel">Confirmation</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    <h4>Are you sure you want to proceed?</h4>
                </div>
                @if (!$approve)
                <div class="row mb-3">
                    <label for="inputRemarks" class="col-sm-12 col-form-label fs-5 fs-bolder" style="color: #0A335D;">Remarks:</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" style="height: 100px" wire:model="remarks_event"></textarea>
                    </div>
                </div>
                @endif
                <div class="row fw-bolder justify-content-center">
                    <button type="button" class="btn {{ $approve ? 'btn-success' : 'btn-danger' }} fw-bolder mt-2" style="width: 100px;" wire:click="{{ $approve ? 'approveEvent' : 'declineEvent' }}('{{ $eventID }}')">{{ $approve ? 'Approve' : 'Decline' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="confirmDeclineEvent" tabindex="-1" aria-labelledby="confirmDeclineEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="confirmDeclineEventLabel">Confirmation</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    <h4>Are you sure you want to proceed?</h4>
                </div>
                @if (!$approve)
                <div class="row mb-3">
                    <label for="inputRemarks" class="col-sm-12 col-form-label fs-5 fs-bolder" style="color: #0A335D;">Remarks:</label>
                    <div class="col-sm-12">
                        <textarea class="form-control" style="height: 100px" wire:model="remarks_event"></textarea>
                        @error('remarks_event')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                @endif
                <div class="row fw-bolder justify-content-center">
                    <button type="button" class="btn {{ $approve ? 'btn-success' : 'btn-danger' }} fw-bolder mt-2" style="width: 100px;" wire:click="{{ $approve ? 'approveEvent' : 'declineEvent' }}('{{ $eventID }}')">{{ $approve ? 'Approve' : 'Decline' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>