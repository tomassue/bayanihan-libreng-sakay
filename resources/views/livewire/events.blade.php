<div>
    <div class="col-12">
        <div class="card border border-secondary">

            <div class="row mx-5 mt-4">
                <div class="col">
                    <div class="card h-100 border border-secondary">
                        <div class="card-body" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                            <div class=" container">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageOne">
                                            <div class="card-body" @if( $filter=='' || $filter=='one' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='one' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">TOTAL NO. OF EVENTS</h1>
                                                <h6 class="text-center">145</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageTwo">
                                            <div class="card-body" @if( $filter=='' || $filter=='two' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='two' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">ON-GOING</h1>
                                                <h6 class="text-center">145</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col mb-3">
                                        <div class="card h-100 m-3 border border-secondary" style="cursor: pointer;" wire:click="pageThree">
                                            <div class="card-body" @if( $filter=='' || $filter=='three' ) style="background-color: #2E8B57; color: #FFFFFF;" @endif>
                                                <h1 class="card-title text-center" @if( $filter=='' || $filter=='three' ) style="font-size: 23px; font-weight: 1000 !important; color: #FFFFFF;" @endif style="font-size: 23px; font-weight: 1000 !important;">DONE</h1>
                                                <h6 class="text-center">145</h6>
                                            </div>
                                        </div>
                                    </div>
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
                                <th scope="col">EVENT NAME</th>
                                <th scope="col">DATE</th>
                                <th scope="col">NO. OF CLIENTS</th>
                                <th scope="col">NO. OF RIDERS</th>
                                <th scope="col">DETAILS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@mdo</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-2">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD EVENT</button>
                </div>
            </div>
            @elseif($filter == 'two')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
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
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@mdo</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @elseif($filter == 'three')
            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <table class="table">
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
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <img src="assets/img/document.png" alt="details" style="height: 20px; width: 20px; cursor: pointer;">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@mdo</td>
                                <td>@fat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                            <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Event Details</h1>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                                <label for="inputText" class="col-sm-3 col-form-label">Event Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3 fw-bolder" style="color: #0A335D;">
                                <label for="inputText" class="col-sm-3 col-form-label">Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="row fw-bolder justify-content-center">
                                <button type="button" class="btn btn-danger fw-bolder mt-2" style="width: 80px;">SAVE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>