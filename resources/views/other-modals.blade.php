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
    <div class="modal-dialog modal-dialog-scrollable modal-l">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="eventDetailsLabel">Event Details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body" wire:loading.remove>
                @if(Auth::user()->user_id !== 'ADMIN')
                @if($eventDetails_org)
                <div class="container">

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Name: </th>
                                <td>{{ucfirst($eventDetails_org->event_name)}}</td>
                            </tr>
                            <tr>
                                <th>Date: </th>
                                <td>{{$eventDetails_org->event_date}}</td>
                            </tr>
                            <tr>
                                <th>Location: </th>
                                <td>{{ucfirst($eventDetails_org->event_location)}}</td>
                            </tr>
                            <tr>
                                <th>Google Map Link: </th>
                                <div class="text-truncate">
                                    <td>@if(empty($eventDetails_org->google_map_link)) {{'N/A'}} @else <a href="{{$eventDetails_org->google_map_link}}" target="_blank">{{$eventDetails_org->google_map_link}}</a> @endif</td>
                                </div>
                            </tr>
                            <tr>
                                <th>Time: </th>
                                <td>{{$eventDetails_org->time}}</td>
                            </tr>
                            <tr>
                                <th>Category: </th>
                                <td>{{ucfirst($eventDetails_org->category)}}</td>
                            </tr>
                            <tr>
                                <th>Tag: </th>
                                <td>@if($eventDetails_org->tag == 0) {{'Ongoing'}} @elseif($eventDetails_org->tag == 1) {{'Done'}} @endif</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                @endif
                @else
                @if($eventsDetails)
                <div class="container">

                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row">Name:</th>
                                <td>{{ucfirst($eventsDetails->event_name)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date:</th>
                                <td>{{$eventsDetails->event_date}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Location:</th>
                                <td>{{ucfirst($eventsDetails->event_location)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Google Map Link</th>
                                <td>@if(empty($eventsDetails->google_map_link)) {{'N/A'}} @else <a href="{{$eventsDetails->google_map_link}}" target="_blank">{{$eventsDetails->google_map_link}}</a> @endif</td>
                            </tr>
                            <tr>
                                <th scope="row">Time:</th>
                                <td>{{$eventsDetails->time}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Category:</th>
                                <td>{{ucfirst($eventsDetails->category)}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Tag:</th>
                                <td>@if($eventsDetails->tag == 0) {{'Ongoing'}} @elseif($eventsDetails->tag == 1) {{'Done'}} @endif</td>
                            </tr>
                            <tr>
                                <th scope="row">No. of Organization:</th>
                                <td>{{ $noOfOrganization ? $noOfOrganization : $noOfOrganization }}</td>
                            </tr>
                            <tr>
                                <th scope="row">No. of Riders:</th>
                                <td>{{ $noOfRiders ? $noOfRiders : $noOfRiders }}</td>
                            </tr>
                            <tr>
                                <th scope="row">No. of Clients:</th>
                                <td>{{ $noOfClients ? $noOfClients : $noOfClients }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @endif
                </div>
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END -->

<!-- LIST OF EVENTS DETAILS -->
@if(Auth::user()->user_id !== 'ADMIN')
<div wire:ignore.self class="modal fade" id="listOfEventsDetailModal" aria-labelledby="listOfEventsDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5 fw-bolder" id="listOfEventsDetailModalLabel">Other details</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                    @if($eventDetails_org)
                    <table class="table table-borderless">
                        <tr>
                            <td scope="row">Map Link</td>
                            <td>@if(empty($eventDetails_org->google_map_link)) {{'N/A'}} @else <a href="{{$eventDetails_org->google_map_link}}" target="_blank">{{$eventDetails_org->google_map_link}}</a> @endif</td>
                        </tr>
                        <tr>
                            <td scope="row">Time</td>
                            <td>{{$eventDetails_org->time}}</td>

                        </tr>
                        <tr>
                            <td scope="row">Category</td>
                            <td>{{ucfirst($eventDetails_org->category)}}</td>
                        </tr>
                        <tr>
                            <td scope="row">Estimated no. of riders needed</td>
                            <td>{{ucfirst($eventDetails_org->estimated_number_of_participants)}}</td>
                        </tr>
                    </table>
                    @endif
                </div>
                <div class="row fw-bolder justify-content-center">
                    <button type="button" class="btn btn-success fw-bolder mt-2" style="width: 100px;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- END -->