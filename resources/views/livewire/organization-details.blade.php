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

                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">
                                    <div class="col">
                                        <h1>{{ $id_org['organization_name'] }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table custom-border">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-start table-success">
                                <td colspan="5">LIST</td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <img src="{{ asset('assets/img/document.png') }}" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>