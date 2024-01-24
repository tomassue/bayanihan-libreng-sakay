<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Registration extends Component
{
    use WithPagination;

    //FILTERS
    public $filter;

    public function render()
    {
        $organization_information = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->paginate(5);

        return view('livewire.registration', [
            'org_data'      =>      $organization_information,
        ]);
    }

    public function mount()
    {
        // Setting the value of this property to one on load.
        $this->filter = 'one';
    }

    public function pageOne()
    {
        $this->filter = 'one';
    }

    public function pageTwo()
    {
        $this->filter = 'two';
    }

    public function pageThree()
    {
        $this->filter = 'three';
    }
}
