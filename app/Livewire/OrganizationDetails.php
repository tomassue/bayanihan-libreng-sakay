<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.page')]
#[Title('Organization Details')]
class OrganizationDetails extends Component
{
    public function render()
    {
        return view('livewire.organization-details');
    }
}
