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
                                        <div class="card m-3 border border-secondary" style="cursor: pointer;" wire:click="$set('tag', null)">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">TOTAL NO. OF EVENTS</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    {{ $total_no_of_events }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px; display: none;">
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
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;" wire:click="$set('tag', '0')">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">UPCOMING</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    {{ $upcoming }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 mb-1" style="padding-right: 0px; padding-left: 0px;">
                                        <div class="card m-3 border border-secondary" style="cursor: pointer; height:86%;" wire:click="$set('tag', '1')">
                                            <div class="card-header h-100" style="border: unset;">
                                                <h1 class="card-title text-center" style="font-size: 23px; font-weight: 1000 !important;">DONE</h1>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-center fs-1">
                                                    {{ $done }}
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
                    <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Events" wire:model.live="search">
                </div>

                <div class="col text-center table-responsive">
                    <div class="pagination-info pb-2 text-start">
                        Page {{ $events->currentPage() }} out of {{ $events->lastPage() }}, Total Records: {{ $events->total() }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 30%;">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF <br> CLIENTS SERVED</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $item)
                            <tr wire:key="{{ $item->id }}">
                                <td>{{ $item->event_name }}</td>
                                <td>{{ $item->event_date }}</td>
                                <td>{{ $item->client_served_count }}</td>
                                <td>
                                    <div style="cursor: pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" wire:click="details({{ $item->id }})">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $events->links('vendor.livewire.custom-pagination') }}
                </div>
                <div class="text-end mt-2">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" wire:click="$dispatch('show_eventSaveModal')">ADD EVENT</button>
                </div>
            </div>
        </div>
    </div>

    <!-- eventSaveModal -->
    <div wire:ignore.self class="modal fade" id="eventSaveModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="eventSaveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="eventSaveModalLabel">Add Event</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="add">
                        <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                            <label for="inputText" class="col-sm-3 col-form-label">Event Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('event_name') is-invalid @enderror" wire:model.live="event_name">
                                @error('event_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                            <label for="inputText" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('event_date') is-invalid @enderror" wire:model.live="event_date">
                                @error('event_date')
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

    <!-- eventDetailsModal -->
    <div wire:ignore.self class="modal fade" id="eventDetailsModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="eventDetailsModalLabel">{{ $event_name }} <br> <span class="badge bg-info text-dark" style="display: {{ $event_done == 1 ? 'display' : 'none' }}"><i class="bi bi-info-circle me-1"></i> This event is done.</span></h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Client-Rider Tagging</h5>

                                <div class="mb-4">
                                    <form data-bitwarden-watching="1">
                                        <div class="row">
                                            <div class="col-md-4" style="display: {{ $event_done == 1 ? 'none' : 'display' }}">
                                                <label for="inputEmail3" class="col-lg-2 col-form-label">Client</label>
                                                <div class="col-lg-10">
                                                    <div id="client-select" wire:ignore></div>
                                                    @error('id_client')
                                                    <div class="custom-error-message">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="display: {{ $event_done == 1 ? 'none' : 'display' }}">
                                                <label for="inputEmail3" class="col-lg-2 col-form-label">Rider</label>
                                                <div class="col-lg-10">
                                                    <div id="rider-select" wire:ignore></div>
                                                    @error('id_individual')
                                                    <div class="custom-error-message">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-4 d-flex justify-content-start align-items-end g-3">
                                                <button type="button" class="btn btn-success" style="display: {{ $event_done == 1 ? 'none' : 'display' }}" wire:click="$dispatch('confirm_tagging')" wire:loading.attr="disabled" wire:target="selected_tag, select_all, tag">Tag</button> &nbsp;
                                                <button type="reset" class="btn btn-secondary ml-2" style="display: {{ $event_done == 1 ? 'none' : 'display' }}" wire:loading.attr="disabled">Reset</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="row mb-2 gy-3">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" style="display: {{ $event_done == 1 ? 'none' : 'display' }}" wire:click="sendMessageToMany" {{ empty($selected_tags) ? 'disabled' : '' }}>Send Message ({{ count($selected_tags) }})</button>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pagination-info pb-2 text-end">
                                            Page {{ $tags->currentPage() }} out of {{ $tags->lastPage() }}, Total Records: {{ $tags->total() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" wire:loading.class="opacity-50">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="3%" style="display: {{ $event_done == 1 ? 'none' : 'display' }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" wire:model.live="select_all" wire:loading.attr="disabled"> ({{ count($selected_tags) }})
                                                    </div>
                                                </th>
                                                <th scope="col" width="24.25%">Client</th>
                                                <th scope="col" width="24.25%">Rider</th>
                                                <th scope="col" width="24.25%">Time</th>
                                                <th scope="col" width="24.25%" style="display: {{ $event_done == 1 ? 'none' : 'display' }}">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($tags as $item)
                                            <tr wire:key="{{ $item->id }}">
                                                <th scope="row" class="align-middle" style="display: {{ $event_done == 1 ? 'none' : 'display' }}">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" wire:model.live="selected_tags" value="{{ $item->id }}" @if(in_array($item->id, $selected_tags)) checked @endif wire:loading.attr="disabled">
                                                    </div>
                                                </th>
                                                <td class="align-middle">{{ $item->client_full_name }}</td>
                                                <td class="align-middle">{{ $item->individual_full_name }}</td>
                                                <td class="align-middle">{{ $item->time }}</td>
                                                <td style="display: {{ $event_done == 1 ? 'none' : 'display' }}">
                                                    <button type="button" class="btn btn-success" style="display: {{ $item->message_status == 'pending' ? 'block' : 'none' }};" title="Send a message" wire:loading.attr="disabled" wire:click="sendMessage({{ $item->id }})"><i class="ri-mail-line"></i></button>
                                                    <button type="button" class="btn btn-secondary" style="display: {{ $item->message_status !== 'pending' ? 'block' : 'none' }};" title="Already sent a message" disabled><i class="ri-mail-check-line"></i></button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $tags->links('vendor.livewire.custom-pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bolder mt-2" style="width: auto;" data-bs-dismiss="modal" wire:click="clear">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('show_eventSaveModal', () => {
        $('#eventSaveModal').modal('show');
    });

    $wire.on('hide_eventSaveModal', () => {
        $('#eventSaveModal').modal('hide');
    });

    $wire.on('show_eventDetailsModal', () => {
        $('#eventDetailsModal').modal('show');
    });

    $wire.on('hide_eventDetailsModal', () => {
        $('#eventDetailsModal').modal('show');
    });

    /* -------------------------------------------------------------------------- */

    VirtualSelect.init({
        ele: '#client-select',
        maxWidth: '100%',
        search: true,
        markSearchResults: true,
        options: @json($clients),
        hasOptionDescription: true
    });

    let id_client = document.querySelector('#client-select');
    id_client.addEventListener('change', () => {
        let data = id_client.value;
        @this.set('id_client', data);
    });

    /* -------------------------------------------------------------------------- */

    VirtualSelect.init({
        ele: '#rider-select',
        maxWidth: '100%',
        search: true,
        markSearchResults: true,
        options: @json($riders),
        hasOptionDescription: true
    });

    let id_individual = document.querySelector('#rider-select');
    id_individual.addEventListener('change', () => {
        let data = id_individual.value;
        @this.set('id_individual', data);
    });

    /* -------------------------------------------------------------------------- */

    $wire.on('confirm_tagging', () => {
        Swal.fire({
            title: "Are you sure you want to proceed?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#198754",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, tag it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.dispatch('tag');
            }
        });
    });

    /* -------------------------------------------------------------------------- */

    $wire.on('reset_plugins', () => {
        document.querySelector('#client-select').reset();
        document.querySelector('#rider-select').reset();
    });
</script>
@endscript