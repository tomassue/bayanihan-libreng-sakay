<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('Update Profile')]
class UpdateProfile extends Component
{
    #[Locked]
    public OrganizationInformationModel $id;

    public function render()
    {
        return view('livewire.update-profile');
    }

    public function mount(OrganizationInformationModel $id)
    {
        $this->id = $id;
    }
}
