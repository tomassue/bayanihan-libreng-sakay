<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use App\Models\User;
use App\Models\EventModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Registration extends Component
{
    use WithPagination;

    public $filter; // FILTERS

    #[Locked]
    public $userID, $approve; // This will store the user_id and will be returned to the variable and will be accessible to the blade. $approve is used to determine if the action is to approve the user or not.

    public function render()
    {
        $organization_one = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', 1)
            ->paginate(5, pageName: 'registered-organization'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_two = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', 0)
            ->paginate(5, pageName: 'for-approval'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $events = EventModel::paginate(5, pageName: 'event-registration');

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

            'events'                 =>      $events,
            'currentPageEvents'      =>      $events->currentPage(),
            'totalPagesEvents'       =>      $events->lastPage(),
            'totalRecordsEvents'     =>      $events->total(),
            'noRecordsEvents'        =>      $events->isEmpty(),
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

    #[On('no-records')]
    public function goBack()
    {
        $this->resetPage(pageName: 'for-approval');
    }

    // Confirmation Message
    public function confirmApproveOrg($user_id) // Organization's reference ID = $user_id
    {
        $this->userID = $user_id;
        $this->approve = true; // If true, it will choose the method it's designated to. Like, if `true`, it will proceed to the method approveOrg. 
    }
    public function confirmDeclineOrg($user_id) // Organization's reference ID = $user_id
    {
        $this->userID = $user_id;
        $this->approve = false; // If true, it will choose the method it's designated to. Like, if `false`, it will proceed to the method declineOrg. 
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

            // We need to close the modal after the process.
            $this->dispatch('close-modal');
            $this->reset('userID', 'approve');
        }
    }

    public function declineOrg($userID)
    {
        if ($userID) {
            $item = User::where('user_id', $userID)->first();
            $item->update([
                'status'    =>      2,
            ]);

            session()->flash('status', 'User declined.');

            // We need to close the modal after the process.
            $this->dispatch('close-modal');
            $this->reset('userID', 'approve');
        }
    }
}
