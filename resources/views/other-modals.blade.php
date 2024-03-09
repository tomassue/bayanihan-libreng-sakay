<!-- --------------------------------------------------- EVENTS ----------------------------------------------------- -->

<!-- eventSaveModal -->
<div wire:ignore.self class="modal fade" id="eventSaveModal" tabindex="-1" aria-labelledby="eventSaveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                <h1 class="modal-title fs-5 fw-bolder" id="eventSaveModalLabel">Event Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="save">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Event Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('eventName') is-invalid @enderror" wire:model.live="eventName">
                            @error('eventName')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control @error('eventDate') is-invalid @enderror" wire:model.live="eventDate">
                            @error('eventDate')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Location</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('event_location') is-invalid @enderror" wire:model.live="event_location">
                            @error('event_location')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Google Map Link</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('google_map_link') is-invalid @enderror" wire:model.live="google_map_link">
                            @error('google_map_link')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Time</label>
                        <div class="col-sm-9 row" style="padding-left: 0px; padding-right: 0px; margin-right: 0px; margin-left: 0px;">
                            <div class=" col-6">
                                <input type="time" class="form-control @error('time_start') is-invalid @enderror" wire:model.live="time_start">
                            </div>
                            <div class="col-6">
                                <input type="time" class="form-control @error('time_end') is-invalid @enderror" wire:model.live="time_end">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row fw-bolder" style="color: #0A335D;">
                        <label for="exampleFormControlInput1" class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-select @error('category') is-invalid @enderror" aria-label="Default select example" wire:model.live="category">
                                <option value="" {{ old('category') ? '' : 'selected' }}>Select...</option>
                                <option value="major" {{ old('category') ? '' : 'selected' }}>Major</option>
                                <option value="minor" {{ old('category') ? '' : 'selected' }}>Minor</option>
                                <option value="normal" {{ old('category') ? '' : 'selected' }}>Normal</option>
                            </select>
                            @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <label for="inputText" class="col-sm-3 col-form-label">Estimated no. of riders</label>
                        <div class="col-sm-9">
                            <input inputmode="numeric" oninput="this.value = this.value.replace(/\D+/g, '').substring(0)" class="form-control @error('estimated_number_of_participants') is-invalid @enderror" wire:model.live="estimated_number_of_participants">
                            @error('estimated_number_of_participants')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: 65px;">SAVE</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- confirmJoinModal -->
<div wire:ignore.self class="modal fade" id="confirmJoinModal" tabindex="-1" aria-labelledby="confirmJoinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="confirmJoinModalLabel">Confirmation</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    <h4>Are you sure you want to proceed?</h4>
                </div>
                <div class="row fw-bolder justify-content-center">
                    <button type="button" class="btn btn-success fw-bolder mt-2" style="width: 100px;" wire:click="joinEvent('{{ $event_ID }}')">PROCEED</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- --------------------------------------------------- END EVENTS ----------------------------------------------------- -->

<!-- EVENT DETAILS -->
<div wire:ignore.self class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="eventDetailsLabel">Event Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                @if(Auth::user()->user_id !== 'ADMIN')
                <p>I am an organization!</p>
                @else
                <div class="container row">
                    {{ $eventsDetails }}
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END -->