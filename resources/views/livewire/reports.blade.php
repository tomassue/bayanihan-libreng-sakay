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

        <div class="col-12">
            <div class="card border border-secondary" wire:loading.class="opacity-50" wire:target="pageOne, pageTwo, pageThree">
                <div class="row mx-5 mt-4">

                    @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                </div>

                <div class="row mx-5 mt-4 mb-4">
                    <div class="col text-center table-responsive">
                        <div class="text-start" style="color: #0A335D;">
                            <h1>Clients</h1>
                        </div>
                        <div class="pagination-info pb-2 text-start">
                            Page {{ $currentPageclients }} out of {{ $totalPagesclients }}, Total Records: {{ $totalRecordsclients }}
                        </div>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">CLIENT'S NAME</th>
                                    <th scope="col">ADDRESS</th>
                                    <th scope="col">CONTACT NUMBER</th>
                                    <th scope="col">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-start" style="border-top: 1px solid black; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; border-radius: 10px;">
                                    <td colspan="5" style="background-image: linear-gradient(#2E8B57 53%, #0A335D 100%);"><span style="font-size:larger; font-weight:bolder; color:#FFFFFF">LIST</span></td>
                                </tr>
                                @foreach($clients as $client)
                                <tr style="border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;">
                                    <th scope="row">{{ $client->first_name }}</th>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success fw-bold mx-auto" style="width: 100px; height: 30px; padding-right: 0px; padding-top: 0px; padding-left: 0px; padding-bottom: 0px;">GENERATE</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $clients->links('vendor.livewire.custom-pagination') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>