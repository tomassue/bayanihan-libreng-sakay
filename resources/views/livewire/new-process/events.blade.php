<div>
    <div class="col-12" wire:loading.class="opacity-50" wire:target="pageOne, pageTwo, pageThree, pageFour">
        <div class="card border border-secondary">
            <div class="row mx-5 mt-4">
                <div class="col">
                    <div class="card h-70 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row justify-content-center">

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer;">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">TOTAL NO. OF EVENTS</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    sdasds
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">LIST OF EVENTS</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    dsf
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">UPCOMING</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    sadsd
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">DONE</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    dsfsd
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-5 mt-4 mb-4">
                <div class="input-group mb-4 mt-4">
                    <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live.debounce.300ms="search_totalNoOfEvents_org">
                </div>

                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page out of , Total Records:
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 30%;">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center">WEE</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- page links -->
                </div>
                <div class="text-end mt-2">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#eventSaveModal">ADD EVENT</button>
                </div>
            </div>
        </div>
    </div>

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
</div>