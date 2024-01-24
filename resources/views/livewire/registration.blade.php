<div>

    <div class="col-12">
        <div class="card border border-secondary">
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

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageOne">
                                            <div class="card-body" @if( $filter=='' || $filter=='one' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='one' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">REGISTERED ORGANIZATION</h1>
                                                <h6 class=" text-center">145</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageTwo">
                                            <div class="card-body" @if( $filter=='' || $filter=='two' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='two' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">FOR APPROVAL</h1>
                                                <h6 class="text-center">{{ App\Models\OrganizationInformationModel::count() }}</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageThree">
                                            <div class="card-body" @if( $filter=='' || $filter=='three' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='three' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">EVENT REGISTRATION</h1>
                                                <h6 class="text-center">145</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <button wire:click="$refresh">Refresh</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($filter == '' || $filter == 'one')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">ADDRESS</th>
                                <th scope="col">MEMBERS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif($filter == 'two')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">CONTACT NUMBER</th>
                                <th scope="col">DETAILS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($org_two as $orgtwo)
                            <tr wire:key="{{ $orgtwo['user_id'] }}">
                                <th scope="row">{{ $orgtwo['organization_name'] }}</th>
                                <td>{{ $orgtwo['contact_number'] }}</td>
                                <td>{{ $orgtwo['address'] }}</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#confirmModal" wire:click="confirm('{{ $orgtwo['user_id'] }}')">APPROVE </span>
                                    <span class="ms-1" style="font-weight: bolder; color: #BF0000; cursor: pointer;">DECLINE</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $org_two->links('vendor.livewire.custom-pagination') }}
                </div>
            </div>
            @elseif($filter == 'three')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>
                                    <span class="me-1" style="font-weight: bolder; color: #0EB263; cursor: pointer;">APPROVE </span>
                                    <span class="ms-1" style="font-weight: bolder; color: #BF0000; cursor: pointer;">DECLINE</span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- CONFIRMATION MESSAGE -->
    <div wire:ignore.self class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="confirmModalLabel">Warning!</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                        <h4>Are you sure you want to proceed?</h4>
                    </div>
                    <div class="row fw-bolder justify-content-center">
                        <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 95px;" wire:click="approveOrg('{{ $userID }}')">Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@script
<script>
    $wire.on('close-modal', () => {
        $('#confirmModal').modal('hide');
    });
</script>
@endscript