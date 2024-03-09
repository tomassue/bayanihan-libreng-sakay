<!-- List of riders modal -->
<div wire:ignore.self class="modal fade" id="listOfRidersModal" tabindex="-1" aria-labelledby="listOfRidersModalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0A335D; color: #FFFFFF;">
                <h1 class="modal-title fs-5" id="listOfRidersModalTitle">List of Riders</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="color: white !important;"></button>
            </div>
            <div class="modal-body">
                @php
                $riders = App\Models\EventOrganizationRidersModel::where('id_event_organization', $event_organization['id'])
                ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
                ->select(
                'event_organization_riders.id_individual',
                DB::raw(" CONCAT(COALESCE(individual_information.first_name, '' ), ' ' , COALESCE(individual_information.middle_name, '' ), ' ' , COALESCE(individual_information.last_name, '' ), ' ' , COALESCE(individual_information.ext_name, '' )) AS rider_fullname"), ) ->get();
                $no = 1;
                @endphp
                @if(empty($riders))
                <div class="pagination-info pt-4">
                    <p class="text-center">No riders.</p>
                </div>
                @else
                <div class="container row">

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Full Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riders as $rider)
                            <tr>
                                <th scope="row">{{ $no }}</th>
                                <td>{{ $rider['rider_fullname'] }}</td>
                            </tr>
                            @php $no++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>