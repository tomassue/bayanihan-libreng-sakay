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
                        Page {{ $events->currentPage() }} out of {{ $events->lastPage() }}, Total Records: {{ $events->total() }}
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 30%;">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $item)
                            <tr wire:key="{{ $item->id }}">
                                <td>{{ $item->event_name }}</td>
                                <td>{{ $item->event_date }}</td>
                                <td>-</td>
                                <td>-</td>
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
                    {{ $events->links() }}
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
                    <h1 class="modal-title fs-5 fw-bolder" id="eventDetailsModalLabel">Event Details</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;" wire:click="clear"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-3">
                            <div class="card mb-3">
                                <div class="row g-0 py-5">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-center align-items-center p-2" style="height: 100%;">
                                            <h1 style="margin-bottom: 0px;">1</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <h5 class="card-title" style="margin-bottom: 0px;">Card with an image on left</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card mb-3">
                                <div class="row g-0 py-5">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-center align-items-center p-2" style="height: 100%;">
                                            <h1 style="margin-bottom: 0px;">1</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <h5 class="card-title" style="margin-bottom: 0px;">Card with an image on left</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card mb-3">
                                <div class="row g-0 py-5">
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-center align-items-center p-2" style="height: 100%;">
                                            <h1 style="margin-bottom: 0px;">1</h1>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body d-flex justify-content-center align-items-center">
                                            <h5 class="card-title" style="margin-bottom: 0px;">Card with an image on left</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="px-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Client-Rider Tagging</h5>

                                    <div class="mb-4">
                                        <form data-bitwarden-watching="1">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Client</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputText" data-ddg-inputtype="identities.fullName">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Rider</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputEmail" data-ddg-inputtype="identities.emailAddress" data-ddg-autofill="true" style="background-size: auto 24px !important; background-position: right center !important; background-repeat: no-repeat !important; background-origin: content-box !important; background-image: url(&quot;data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTI4IiBoZWlnaHQ9IjEyOCIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDEyOCAxMjgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CiAgICA8cGF0aCBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Im02NCAxMjhjMzUuMzQ2IDAgNjQtMjguNjU0IDY0LTY0cy0yOC42NTQtNjQtNjQtNjQtNjQgMjguNjU0LTY0IDY0IDI4LjY1NCA2NCA2NCA2NHoiIGZpbGw9IiNkZTU4MzMiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNzMgMTExLjc1YzAtLjUuMTIzLS42MTQtMS40NjYtMy43ODItNC4yMjQtOC40NTktOC40Ny0yMC4zODQtNi41NC0yOC4wNzUuMzUzLTEuMzk3LTMuOTc4LTUxLjc0NC03LjA0LTUzLjM2NS0zLjQwMi0xLjgxMy03LjU4OC00LjY5LTExLjQxOC01LjMzLTEuOTQzLS4zMS00LjQ5LS4xNjQtNi40ODIuMTA1LS4zNTMuMDQ3LS4zNjguNjgzLS4wMy43OTggMS4zMDguNDQzIDIuODk1IDEuMjEyIDMuODMgMi4zNzUuMTc4LjIyLS4wNi41NjYtLjM0Mi41NzctLjg4Mi4wMzItMi40ODIuNDAyLTQuNTkzIDIuMTk1LS4yNDQuMjA3LS4wNDEuNTkyLjI3My41MyA0LjUzNi0uODk3IDkuMTctLjQ1NSAxMS45IDIuMDI3LjE3Ny4xNi4wODQuNDUtLjE0Ny41MTItMjMuNjk0IDYuNDQtMTkuMDAzIDI3LjA1LTEyLjY5NiA1Mi4zNDQgNS42MTkgMjIuNTMgNy43MzMgMjkuNzkyIDguNCAzMi4wMDRhLjcxOC43MTggMCAwIDAgLjQyMy40NjdjOC4xNTYgMy4yNDggMjUuOTI4IDMuMzkyIDI1LjkyOC0yLjEzMnoiIGZpbGw9IiNkZGQiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPHBhdGggZD0ibTc2LjI1IDExNi41Yy0yLjg3NSAxLjEyNS04LjUgMS42MjUtMTEuNzUgMS42MjUtNC43NjQgMC0xMS42MjUtLjc1LTE0LjEyNS0xLjg3NS0xLjU0NC00Ljc1MS02LjE2NC0xOS40OC0xMC43MjctMzguMTg1bC0uNDQ3LTEuODI3LS4wMDQtLjAxNWMtNS40MjQtMjIuMTU3LTkuODU1LTQwLjI1MyAxNC40MjctNDUuOTM4LjIyMi0uMDUyLjMzLS4zMTcuMTg0LS40OTItMi43ODYtMy4zMDUtOC4wMDUtNC4zODgtMTQuNjA1LTIuMTExLS4yNy4wOTMtLjUwNi0uMTgtLjMzNy0uNDEyIDEuMjk0LTEuNzgzIDMuODIzLTMuMTU1IDUuMDcxLTMuNzU2LjI1OC0uMTI0LjI0Mi0uNTAyLS4wMy0uNTg4YTI3Ljg3NyAyNy44NzcgMCAwIDAgLTMuNzcyLS45Yy0uMzctLjA1OS0uNDAzLS42OTMtLjAzMi0uNzQzIDkuMzU2LTEuMjU5IDE5LjEyNSAxLjU1IDI0LjAyOCA3LjcyNmEuMzI2LjMyNiAwIDAgMCAuMTg2LjExNGMxNy45NTIgMy44NTYgMTkuMjM4IDMyLjIzNSAxNy4xNyAzMy41MjgtLjQwOC4yNTUtMS43MTUuMTA4LTMuNDM4LS4wODUtNi45ODYtLjc4MS0yMC44MTgtMi4zMjktOS40MDIgMTguOTQ4LjExMy4yMS0uMDM2LjQ4OC0uMjcyLjUyNS02LjQzOCAxIDEuODEyIDIxLjE3MyA3Ljg3NSAzNC40NjF6IiBmaWxsPSIjZmZmIi8+CiAgICA8cGF0aCBkPSJtODQuMjggOTAuNjk4Yy0xLjM2Ny0uNjMzLTYuNjIxIDMuMTM1LTEwLjExIDYuMDI4LS43MjgtMS4wMzEtMi4xMDMtMS43OC01LjIwMy0xLjI0Mi0yLjcxMy40NzItNC4yMTEgMS4xMjYtNC44OCAyLjI1NC00LjI4My0xLjYyMy0xMS40ODgtNC4xMy0xMy4yMjktMS43MS0xLjkwMiAyLjY0Ni40NzYgMTUuMTYxIDMuMDAzIDE2Ljc4NiAxLjMyLjg0OSA3LjYzLTMuMjA4IDEwLjkyNi02LjAwNS41MzIuNzQ5IDEuMzg4IDEuMTc4IDMuMTQ4IDEuMTM3IDIuNjYyLS4wNjIgNi45NzktLjY4MSA3LjY0OS0xLjkyMS4wNC0uMDc1LjA3NS0uMTY0LjEwNS0uMjY2IDMuMzg4IDEuMjY2IDkuMzUgMi42MDYgMTAuNjgyIDIuNDA2IDMuNDctLjUyMS0uNDg0LTE2LjcyMy0yLjA5LTE3LjQ2N3oiIGZpbGw9IiMzY2E4MmIiLz4KICAgIDxwYXRoIGQ9Im03NC40OSA5Ny4wOTdjLjE0NC4yNTYuMjYuNTI2LjM1OC44LjQ4MyAxLjM1MiAxLjI3IDUuNjQ4LjY3NCA2LjcwOS0uNTk1IDEuMDYyLTQuNDU5IDEuNTc0LTYuODQzIDEuNjE1cy0yLjkyLS44MzEtMy40MDMtMi4xODFjLS4zODctMS4wODEtLjU3Ny0zLjYyMS0uNTcyLTUuMDc1LS4wOTgtMi4xNTguNjktMi45MTYgNC4zMzQtMy41MDYgMi42OTYtLjQzNiA0LjEyMS4wNzEgNC45NDQuOTQgMy44MjgtMi44NTcgMTAuMjE1LTYuODg5IDEwLjgzOC02LjE1MiAzLjEwNiAzLjY3NCAzLjQ5OSAxMi40MiAyLjgyNiAxNS45MzktLjIyIDEuMTUxLTEwLjUwNS0xLjEzOS0xMC41MDUtMi4zOCAwLTUuMTUyLTEuMzM3LTYuNTY1LTIuNjUtNi43MXptLTIyLjUzLTEuNjA5Yy44NDMtMS4zMzMgNy42NzQuMzI1IDExLjQyNCAxLjk5MyAwIDAtLjc3IDMuNDkxLjQ1NiA3LjYwNC4zNTkgMS4yMDMtOC42MjcgNi41NTgtOS44IDUuNjM3LTEuMzU1LTEuMDY1LTMuODUtMTIuNDMyLTIuMDgtMTUuMjM0eiIgZmlsbD0iIzRjYmEzYyIvPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNTUuMjY5IDY4LjQwNmMuNTUzLTIuNDAzIDMuMTI3LTYuOTMyIDEyLjMyMS02LjgyMiA0LjY0OC0uMDE5IDEwLjQyMi0uMDAyIDE0LjI1LS40MzZhNTEuMzEyIDUxLjMxMiAwIDAgMCAxMi43MjYtMy4wOTVjMy45OC0xLjUxOSA1LjM5Mi0xLjE4IDUuODg3LS4yNzIuNTQ0Ljk5OS0uMDk3IDIuNzIyLTEuNDg4IDQuMzA5LTIuNjU2IDMuMDMtNy40MzEgNS4zOC0xNS44NjUgNi4wNzYtOC40MzMuNjk4LTE0LjAyLTEuNTY1LTE2LjQyNSAyLjExOC0xLjAzOCAxLjU4OS0uMjM2IDUuMzMzIDcuOTIgNi41MTIgMTEuMDIgMS41OSAyMC4wNzItMS45MTcgMjEuMTkuMjAxIDEuMTE5IDIuMTE4LTUuMzIzIDYuNDI4LTE2LjM2MiA2LjUxOHMtMTcuOTM0LTMuODY1LTIwLjM3OS01LjgzYy0zLjEwMi0yLjQ5NS00LjQ5LTYuMTMzLTMuNzc1LTkuMjc5eiIgZmlsbD0iI2ZjMyIgZmlsbC1ydWxlPSJldmVub2RkIi8+CiAgICA8ZyBmaWxsPSIjMTQzMDdlIiBvcGFjaXR5PSIuOCI+CiAgICAgIDxwYXRoIGQ9Im02OS4zMjcgNDIuMTI3Yy42MTYtMS4wMDggMS45ODEtMS43ODYgNC4yMTYtMS43ODYgMi4yMzQgMCAzLjI4NS44ODkgNC4wMTMgMS44OC4xNDguMjAyLS4wNzYuNDQtLjMwNi4zNGE1OS44NjkgNTkuODY5IDAgMCAxIC0uMTY4LS4wNzNjLS44MTctLjM1Ny0xLjgyLS43OTUtMy41NC0uODItMS44MzgtLjAyNi0yLjk5Ny40MzUtMy43MjcuODMxLS4yNDYuMTM0LS42MzQtLjEzMy0uNDg4LS4zNzJ6bS0yNS4xNTcgMS4yOWMyLjE3LS45MDcgMy44NzYtLjc5IDUuMDgxLS41MDQuMjU0LjA2LjQzLS4yMTMuMjI3LS4zNzctLjkzNS0uNzU1LTMuMDMtMS42OTItNS43Ni0uNjc0LTIuNDM3LjkwOS0zLjU4NSAyLjc5Ni0zLjU5MiA0LjAzOC0uMDAyLjI5Mi42LjMxNy43NTYuMDcuNDItLjY3IDEuMTItMS42NDYgMy4yODktMi41NTN6Ii8+CiAgICAgIDxwYXRoIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0ibTc1LjQ0IDU1LjkyYTMuNDcgMy40NyAwIDAgMSAtMy40NzQtMy40NjIgMy40NyAzLjQ3IDAgMCAxIDMuNDc1LTMuNDYgMy40NyAzLjQ3IDAgMCAxIDMuNDc0IDMuNDYgMy40NyAzLjQ3IDAgMCAxIC0zLjQ3NSAzLjQ2MnptMi40NDctNC42MDhhLjg5OS44OTkgMCAwIDAgLTEuNzk5IDBjMCAuNDk0LjQwNS44OTUuOS44OTUuNDk5IDAgLjktLjQuOS0uODk1em0tMjUuNDY0IDMuNTQyYTQuMDQyIDQuMDQyIDAgMCAxIC00LjA0OSA0LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSAtNC4wNS00LjAzNyA0LjA0NSA0LjA0NSAwIDAgMSA0LjA1LTQuMDM3IDQuMDQ1IDQuMDQ1IDAgMCAxIDQuMDUgNC4wMzd6bS0xLjE5My0xLjMzOGExLjA1IDEuMDUgMCAwIDAgLTIuMDk3IDAgMS4wNDggMS4wNDggMCAwIDAgMi4wOTcgMHoiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPC9nPgogICAgPHBhdGggY2xpcC1ydWxlPSJldmVub2RkIiBkPSJtNjQgMTE3Ljc1YzI5LjY4NSAwIDUzLjc1LTI0LjA2NSA1My43NS01My43NXMtMjQuMDY1LTUzLjc1LTUzLjc1LTUzLjc1LTUzLjc1IDI0LjA2NS01My43NSA1My43NSAyNC4wNjUgNTMuNzUgNTMuNzUgNTMuNzV6bTAgNWMzMi40NDcgMCA1OC43NS0yNi4zMDMgNTguNzUtNTguNzVzLTI2LjMwMy01OC43NS01OC43NS01OC43NS01OC43NSAyNi4zMDMtNTguNzUgNTguNzUgMjYuMzAzIDU4Ljc1IDU4Ljc1IDU4Ljc1eiIgZmlsbD0iI2ZmZiIgZmlsbC1ydWxlPSJldmVub2RkIi8+Cjwvc3ZnPg==&quot;) !important; transition: background !important;">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-start align-items-center">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                        <button type="reset" class="btn btn-secondary ml-2">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Position</th>
                                                    <th scope="col">Age</th>
                                                    <th scope="col">Start Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Brandon Jacob</td>
                                                    <td>Designer</td>
                                                    <td>28</td>
                                                    <td>2016-05-25</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Bridie Kessler</td>
                                                    <td>Developer</td>
                                                    <td>35</td>
                                                    <td>2014-12-05</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Ashleigh Langosh</td>
                                                    <td>Finance</td>
                                                    <td>45</td>
                                                    <td>2011-08-12</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>Angus Grady</td>
                                                    <td>HR</td>
                                                    <td>34</td>
                                                    <td>2012-06-11</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5</th>
                                                    <td>Raheem Lehner</td>
                                                    <td>Dynamic Division Officer</td>
                                                    <td>47</td>
                                                    <td>2011-04-19</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
</script>
@endscript