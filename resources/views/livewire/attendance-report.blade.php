<div>
    <div class="col">
        <div class="card">
            <div class="card-body pt-3">

                <div class="row g-2">
                    <div class="col-12 pb-3">
                        <h1>Attendance Report</h1>
                    </div>

                    <div class="col-sm-12 col-lg-9 mb-4">
                        <form wire:submit="search">
                            <div class="row g-2">
                                <label for="inputEmail3" class="col-sm-1 col-md-2 col-lg-2 col-form-label">Select Event</label>
                                <div class="col-sm-4 col-md-5 col-lg-5">
                                    <input type="date" class="form-control" wire:model="start_date" required>
                                </div>
                            </div>
                    </div>

                    <div class="col-sm-12 col-lg-3 text-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <button type="button" class="btn btn-secondary" wire:click="clear">Clear</button>
                        </form>
                    </div>

                    <!-- <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Print</button>
                    </div> -->

                    <div class="col-12">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>