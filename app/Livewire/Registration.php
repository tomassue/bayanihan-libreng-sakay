<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Registration extends Component
{
    use WithPagination;

    public $filter; // FILTERS
    public $userID; // This will store the user_id and will be returned to the variable and will be accessible to the blade.

    public function render()
    {
        $organization_two = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->paginate(5);

        return view('livewire.registration', [
            'org_two'      =>      $organization_two,
        ]);
    }

    // FILTER PAGES
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

    // Confirmation Message
    public function confirm($user_id) // Organization's reference ID = $user_id
    {
        $this->userID = $user_id;
    }

    public function approveOrg($userID)
    {
        if ($userID) {
            $item = User::findOrFail($userID);
            $item->update([
                'status'    =>      1,
            ]);

            session()->flash('status', 'Approved successully.');

            // We need to close the modal after the process.
            $this->dispatch('close-modal');
            $this->reset('userID');
        }
    }
}
