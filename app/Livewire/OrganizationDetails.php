<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\OrganizationInformationModel;
use App\Models\IndividualInformationModel;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Organization Details')]

class OrganizationDetails extends Component
{
    use WithPagination;

    public OrganizationInformationModel $id_org;

    public function render()
    {
        $individual = IndividualInformationModel::where('id_organization', $this->id_org['id'])
            ->join('users', 'individual_information.user_id', '=', 'users.user_id')
            // ->where('users.status', 1)
            ->orderBy('status', 'DESC')
            ->orderBy('last_name', 'ASC')
            ->paginate(10);

        return view('livewire.organization-details', [
            'individual'       =>      $individual,
            'currentPage'      =>      $individual->currentPage(),
            'totalPages'       =>      $individual->lastPage(),
            'totalRecords'     =>      $individual->total(),
            'noRecords'        =>      $individual->isEmpty(),
        ]);
    }

    public function mount(OrganizationInformationModel $id_organization) // It's like, OrganizationInformationModel::findOrFail($id_organization);
    {
        $this->id_org = $id_organization;
    }
}
