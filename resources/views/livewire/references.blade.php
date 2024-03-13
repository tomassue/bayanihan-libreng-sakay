<div>
    <div>
        <style>
            .custom-border {
                border: 1px solid #dee2e6;
                /* Set your preferred border color here */
                border-radius: 0.25rem;
                /* Optional: Add border radius for a rounded appearance */
            }

            .custom-border thead th,
            .custom-border tbody tr:last-child td {
                border-bottom: none;
                /* Remove border for the last row in tbody */
            }
        </style>

        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="col-12">
            <div class="card border border-secondary" wire:loading.class="opacity-50" wire:target="pageOne, pageTwo, pageThree">
                <div class="row mx-5 mt-4">

                </div>

                <div class="row mx-5 mt-4 mb-4">
                    <div class="col text-center table-responsive">
                        <div class="text-start" style="color: #0A335D;">
                            <h1>Schools</h1>
                        </div>
                        <div class="input-group mb-4 mt-4">
                            <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Clients" wire:model.live.debounce.300ms="search_school">
                        </div>

                        <div class="pagination-info pb-2 text-start">
                            Page
                        </div>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">NO.</th>
                                    <th scope="col">SCHOOL NAME</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                    <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                                </tr>
                                @foreach($school as $item)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $item->school_name }}</td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end mt-2 mb-3">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- addClientModal -->
    <div wire:ignore.self class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="addClientModalLabel">Add Client</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form wire:submit="saveClient">
                            <div class="container row">

                                <div class="col-sm-12 col-md-12 col-lg-6">

                                    <div class="mb-3 row">
                                        <label for="exampleFormControlInput1" class="col-12">Last Name</label>
                                        <div class="col-12">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="exampleFormControlInput1" placeholder="" wire:model.live="last_name">
                                            @error('last_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

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

@script
<script>
    $wire.on('close-addClientModal-Modal', () => {
        $('#addClientModal').modal('hide');
    });
</script>
@endscript