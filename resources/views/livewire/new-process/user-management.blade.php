<div>
    <div class="col-12">
        <div class="card border border-secondary">
            <div class="row mx-5 mt-4">

            </div>

            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <div class="text-start" style="color: #0A335D;">
                        <h1>User Management</h1>
                    </div>

                    <div class="input-group mb-4 mt-4">
                        <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Search" wire:model.live="search">
                    </div>

                    <div class="pagination-info pb-2 text-end">
                        <!-- PAGE -->
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">ACCOUNT TYPE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($admin as $key=>$item)
                            <tr>
                                <td colspan="6" class="text-center">No data</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- custom pagination -->
                    <div class="text-end mt-2 mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" wire:click="$dispatch('show_addModal')">ADD USER</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>