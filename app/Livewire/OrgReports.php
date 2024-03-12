<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.page')]
#[Title('Organization Report')]

class OrgReports extends Component
{
    use WithPagination;

    // Search
    public $start_date = "", $end_date = "";

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->start_date = "";
        $this->end_date   = "";
    }

    public function render()
    {
        $query = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select(
                'organization_name',
                DB::raw("DATE_FORMAT(date_established, '%b %d, %Y') AS date_established"),
                'address',
                'representative_name',
                'representative_position',
                'representative_contact_number',
                'users.contactNumber AS contact_number'
            )
            ->orderBy('organization_information.created_at', 'DESC');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('organization_information.created_at', [$this->start_date, $this->end_date]);
        }

        $organizations = $query->paginate(5);

        return view('livewire.org-reports', [
            'organizations'     =>  $organizations,
            'currentPage'       =>  $organizations->currentPage(),
            'totalPages'        =>  $organizations->lastPage(),
            'totalRecords'      =>  $organizations->total(),
            'noRecords'         =>  $organizations->isEmpty(),
        ]);
    }
}
