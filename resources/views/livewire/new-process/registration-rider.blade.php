<div>
    <div class="col-12">
        <div class="card border border-secondary">
            <div class="row mx-5 mt-4">

            </div>

            <div class="row mx-5 mt-4 mb-4">
                <div class="col text-center table-responsive">
                    <div class="text-start" style="color: #0A335D;">
                        <h1>Riders</h1>
                    </div>

                    <div class="input-group mb-4 mt-4">
                        <span class="input-group-text fw-bolder fs-4" id="basic-addon1"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control form-control-lg" aria-label="Search" aria-describedby="basic-addon1" placeholder="Search" wire:model.live="search">
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-1 col-form-label text-start">Filter</label>
                        <div class="col-sm-3">
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="filter_organization">
                                <option selected="" value="">Organization (All)</option>
                                @foreach ($organizations as $item)
                                <option value="{{ $item->id }}">{{ $item->organization_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-select" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model.live="filter_status">
                                <option selected="" value="">Status (All)</option>
                                <option value="0">Pending</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>

                    <div class="pagination-info pb-2 text-end">
                        Page {{ $riders->currentPage() }} out of {{ $riders->lastpage() }}, Total Records: {{ $riders->total() }}
                    </div>

                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th scope="col">NO.</th>
                                <th scope="col">NAME</th>
                                <th scope="col">ORGANIZATION</th>
                                <th scope="col">PHONE NUMBER</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riders as $index=>$item)
                            <tr wire:key="{{ $item->user_id }}">
                                <td>{{ $index+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->organization_name }}</td>
                                <td>{{ $item->contact_number }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'Pending' ? 'bg-danger' : 'bg-success' }}">{{ $item->status }}</span>
                                </td>
                                <td>
                                    <span style="cursor: pointer;" title="Edit" wire:click="edit('{{ $item->user_id }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 2H9C4 2 2 4 2 9v6c0 5 2 7 7 7h6c5 0 7-2 7-7v-2" stroke="#0f0f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M16.04 3.02 8.16 10.9c-.3.3-.6.89-.66 1.32l-.43 3.01c-.16 1.09.61 1.85 1.7 1.7l3.01-.43c.42-.06 1.01-.36 1.32-.66l7.88-7.88c1.36-1.36 2-2.94 0-4.94-2-2-3.58-1.36-4.94 0Z" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M14.91 4.15a7.144 7.144 0 0 0 4.94 4.94" stroke="#0f0f0f" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $riders->links('vendor.livewire.custom-pagination') }}
                    <div class="text-end mt-2 mb-3">
                        <!-- Button trigger modal -->
                        <!-- <button type="button" class="btn btn-primary fs-5 fw-bold" style="width: 160px; background-color: #0A335D;" wire:click="$dispatch('show_addModal')">ADD RECORD</button> -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- riderModal -->
    <div wire:ignore.self class="modal fade" id="riderModal" tabindex="-1" aria-labelledby="riderModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF  ">
                    <h1 class="modal-title fs-5 fw-bolder" id="riderModalLabel" wire:loading.remove>{{ $editMode ? 'Edit' : 'Add' }} Rider</h1>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
                </div>

                <div class="modal-body" wire:loading.remove>
                    <form wire:submit="{{ $editMode ? 'update' : 'add' }}" novalidate>
                        <div class="mb-3 row">
                            <label for="exampleFormControlInput1" class="col-12">Status</label>
                            <div class="col-12">
                                <select class="form-select @error('status') is-invalid @enderror" aria-label="Default select example" data-ddg-inputtype="unknown" wire:model="status">
                                    <option value="">Status</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Active</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="my-5 mx-auto" wire:loading>
                    <div class="spinner-grow text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="modal-footer" wire:loading.remove>
                    <button type="submit" class="btn btn-success fw-bolder mt-2" style="width: auto;">{{$editMode ? 'SAVE' : 'UPDATE'}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('show_riderModal', () => {
        $('#riderModal').modal('show');
    });

    $wire.on('hide_riderModal', () => {
        $('#riderModal').modal('hide');
    });
</script>
@endscript