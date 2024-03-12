<?php

namespace App\Livewire;

use App\Models\IndividualInformationModel;
use App\Models\OrganizationInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Rider Report')]

class RidersReports extends Component
{
    use WithPagination;

    // Search
    public $start_date = "", $end_date = "", $query_org = "";

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->query_org  = "";
        $this->start_date = "";
        $this->end_date   = "";
    }

    public function render()
    {
        $query = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
            ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
            ->select(
                'individual_information.id',
                'organization_information.organization_name AS organization',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
            )
            ->where('individual_information.id_organization', 'like', '%' . $this->query_org . '%');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('individual_information.created_at', [$this->start_date, $this->end_date]);
        }

        $riders = $query->paginate(5);

        // Select Field (Organization)
        $organizations = OrganizationInformationModel::select('id AS orgID', 'organization_name')
            ->get();

        return view('livewire.riders-reports', [
            'riders'        =>  $riders,
            'currentPage'   =>  $riders->currentPage(),
            'totalPages'    =>  $riders->lastPage(),
            'totalRecords'  =>  $riders->total(),
            'noRecords'     =>  $riders->isEmpty(),

            'organizations' =>  $organizations
        ]);
    }
}
