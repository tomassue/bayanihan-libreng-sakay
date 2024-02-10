<!-- --------------------------------------------------- EVENTS ----------------------------------------------------- -->

<!-- eventSaveModal -->
<div wire:ignore.self class="modal fade" id="eventSaveModal" tabindex="-1" aria-labelledby="eventSaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="eventSaveModalLabel">Event Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <form wire:submit="save">
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Event Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('eventName') is-invalid @enderror" wire:model.blur="eventName">
                            @error('eventName')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control @error('eventDate') is-invalid @enderror" wire:model.blur="eventDate">
                            @error('eventDate')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="submit" class="btn fw-bolder mt-2" style="width: 80px; background-color: #2e8b57; color:#FFFFFF;">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- confirmJoinModal -->
<div wire:ignore.self class="modal fade" id="confirmJoinModal" tabindex="-1" aria-labelledby="confirmJoinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="confirmJoinModalLabel">Warning!</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    <h4>Are you sure you want to proceed?</h4>
                </div>
                <div class="row fw-bolder justify-content-center">
                    <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 100px;" wire:click="joinEvent('{{ $event_ID }}')">PROCEED</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- --------------------------------------------------- END EVENTS ----------------------------------------------------- -->