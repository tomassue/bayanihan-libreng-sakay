<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\OrganizationInformationModel;

#[Layout('components.layouts.page')]
#[Title('Organization Details')]
class OrganizationDetails extends Component
{
    public OrganizationInformationModel $id_org;

    public function render()
    {
        return view('livewire.organization-details', [
            'data'      =>      $this->id_org,
        ]);
    }

    public function mount(OrganizationInformationModel $id_organization) // It's like, OrganizationInformationModel::findOrFail($id_organization);
    {
        $this->id_org = $id_organization;
    }
}
