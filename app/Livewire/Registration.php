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
        $organization_one = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', '1')
            ->paginate(5, pageName: 'registered-organization'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_two = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', '0')
            ->paginate(5, pageName: 'for-approval'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        return view('livewire.registration', [
            'org_one'          =>      $organization_one,
            'currentPageOne'   =>      $organization_one->currentPage(),
            'totalPagesOne'    =>      $organization_one->lastPage(),
            'totalRecordsOne'  =>      $organization_one->total(),
            'noRecordsOne'     =>      $organization_one->isEmpty(),

            'org_two'          =>      $organization_two,
            'currentPage'      =>      $organization_two->currentPage(),
            'totalPages'       =>      $organization_two->lastPage(),
            'totalRecords'     =>      $organization_two->total(),
            'noRecords'        =>      $organization_two->isEmpty(),
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
    public function confirmOrg($user_id) // Organization's reference ID = $user_id
    {
        $this->userID = $user_id;
    }

    public function approveOrg($userID)
    {
        if ($userID) {
            // $item = User::findOrFail($userID); findOrFail will automatically look in the primary key. In case you refer to other columns not the primary key. You must put protected $primaryKey = 'column_name' and the application will automatically consider the column_name as the primary key.
            $item = User::where('user_id', $userID)->first();
            $item->update([
                'status'    =>      1,
            ]);

            session()->flash('status', 'Approved successully.');

            // // We need to close the modal after the process.
            $this->dispatch('close-modal');
            $this->reset('userID');
            $this->resetPage();
        }
    }
}
