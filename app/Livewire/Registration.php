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

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Registration extends Component
{
    use WithPagination;

    public $filter, $pagetwo, $pagethree; // FILTERS

    #[Locked]
    public $userID, $approve, $eventID; // This will store the user_id and will be returned to the variable and will be accessible to the blade. $approve is used to determine if the action is to approve the user or not.

    public function render()
    {
        $organization_one = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'organization_information.*') // In my case, i have two different tables and their primary key's name are the same. I put an alias to the id of the other table so that it will distinguish from the other one. his renames the 'name' column from the 'tags' table to 'tag_name' in the result set. This is often done when you have multiple columns with the same name from different tables to avoid naming conflicts. 'products.*': This selects all columns from the 'products' table.
            ->where('status', 1)
            ->paginate(5, pageName: 'registered-organizations'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_two = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', 0)
            ->paginate(5, pageName: 'for-approval'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_declined = OrganizationInformationModel::orderBy('organization_name', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->where('status', 2)
            ->paginate(5, pageName: 'declined-organizations');

        $events = EventModel::where('status', 0)
            ->where('tag', 0)
            ->paginate(5, pageName: 'event-registrations');

        $events_declined = EventModel::where('status', 2)
            ->where('tag', 0)
            ->paginate(5, pageName: 'declined_events');

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

            'org_declined'                =>      $organization_declined,
            'currentPageOrgDeclined'      =>      $organization_declined->currentPage(),
            'totalPagesOrgDeclined'       =>      $organization_declined->lastPage(),
            'totalRecordsOrgDeclined'     =>      $organization_declined->total(),
            'noRecordsOrgDeclined'        =>      $organization_declined->isEmpty(),

            'events'                 =>      $events,
            'currentPageEvents'      =>      $events->currentPage(),
            'totalPagesEvents'       =>      $events->lastPage(),
            'totalRecordsEvents'     =>      $events->total(),
            'noRecordsEvents'        =>      $events->isEmpty(),

            'events_declined'                =>      $events_declined,
            'currentPageEventsDeclined'      =>      $events_declined->currentPage(),
            'totalPagesEventsDeclined'       =>      $events_declined->lastPage(),
            'totalRecordsEventsDeclined'     =>      $events_declined->total(),
            'noRecordsEventsDeclined'        =>      $events_declined->isEmpty(),
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

    public function pageTwoPending()
    {
        $this->pagetwo = 'twopending';
    }

    public function pageTwoDeclined()
    {
        $this->pagetwo = 'twodeclined';
    }

    public function pageThree()
    {
        $this->filter = 'three';
    }

    public function pageThreePending()
    {
        $this->pagethree = 'threepending';
    }

    public function pageThreeDeclined()
    {
        $this->pagethree = 'threedeclined';
    }

    // Confirmation Message
    public function confirmApproveOrg($user_id) // Organization's reference ID = $user_id
    {
        $this->approve = true; // If true, it will choose the method it's designated to. Like, if `true`, it will proceed to the method approveOrg. 
        $this->userID = $user_id;
    }
    public function confirmApproveOrg2($user_id) // Organization's reference ID = $user_id
    {
        $this->userID = $user_id;
    }
    public function confirmDeclineOrg($user_id) // Organization's reference ID = $user_id
    {
        $this->approve = false; // If true, it will choose the method it's designated to. Like, if `false`, it will proceed to the method declineOrg. 
        $this->userID = $user_id;
    }

    public function confirmApproveEvent($event_id) // Organization's reference ID = $user_id
    {
        $this->approve = true; // If true, it will choose the method it's designated to. Like, if `true`, it will proceed to the method approveOrg. 
        $this->eventID = $event_id;
    }

    public function confirmDeclineEvent($event_id) // Organization's reference ID = $user_id
    {
        $this->approve = false; // If true, it will choose the method it's designated to. Like, if `true`, it will proceed to the method approveOrg. 
        $this->eventID = $event_id;
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

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function approveOrg2($userID)
    {
        if ($userID) {
            // $item = User::findOrFail($userID); findOrFail will automatically look in the primary key. In case you refer to other columns not the primary key. You must put protected $primaryKey = 'column_name' and the application will automatically consider the column_name as the primary key.
            $item = User::where('user_id', $userID)->first();
            $item->update([
                'status'    =>      1,
            ]);

            session()->flash('status', 'Approved successully.');

            // We need to close the modal after the process.
            $this->dispatch('close-modal2');
            $this->reset('userID', 'approve');
            $this->resetPage(pageName: 'declined-organization');
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

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function approveEvent($eventID)
    {
        if ($eventID) {
            $item = EventModel::where('id', $eventID)->first();
            $item->update([
                'status'    =>     1,
            ]);

            session()->flash('status', 'Event approved.');

            // We need to close the modal after the process.
            $this->dispatch('close-modal3');
            $this->reset('eventID', 'approve');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function declineEvent($eventID)
    {
        if ($eventID) {
            $item = EventModel::where('id', $eventID)->first();
            $item->update([
                'status'    =>     2,
            ]);

            session()->flash('status', 'Event declined');

            $this->dispatch('close-modal3');
            $this->reset('eventID', 'approve');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }
}
