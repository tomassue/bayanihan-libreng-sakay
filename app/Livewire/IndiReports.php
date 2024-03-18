<?php

namespace App\Livewire;

use App\Models\IndividualInformationModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Riders Reports')]
class IndiReports extends Component
{
    use WithPagination;

    // indiReportModal
    public $indiID;

    public function render()
    {
        $auth_org_id = Auth::user()->organization_information->id;

        $riders = IndividualInformationModel::where('id_organization', $auth_org_id)
            ->select(
                'id',
                DB::raw("CONCAT(COALESCE(last_name, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
            )
            ->paginate(10);

        // indiReportModal
        $riderTransactions = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
            ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('client_information', 'transactions.id_client', '=', 'client_information.id')
            ->select(
                'events.event_name AS event',
                'events.event_date AS date',
                DB::raw("CONCAT(COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname")
            )
            ->where('event_organization_riders.id_individual', $this->indiID)
            ->get();

        return view('livewire.indi-reports', [
            'riders'                       =>      $riders,
            'currentPage'                  =>      $riders->currentPage(),
            'totalPages'                   =>      $riders->lastPage(),
            'totalRecords'                 =>      $riders->total(),
            'noRecords'                    =>      $riders->isEmpty(),

            'riderTransactions'            =>      $riderTransactions
        ]);
    }

    public function getindiID($id)
    {
        $this->indiID = $id;
    }
}
