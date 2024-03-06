<?php

namespace App\Livewire;

use App\Models\OrganizationInformationModel;
use App\Models\User;
use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use App\Models\IndividualInformationModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.page')]
#[Title('Registration')]

class Registration extends Component
{
    use WithPagination;

    public $filter, $pageone, $pagetwo, $pagethree; // FILTERS

    #[Locked] // Locked properties cannot be updated. This is only good for accessing data or passing data.
    public $userID, $approve, $eventID, $individualID; // This will store the user_id and will be returned to the variable and will be accessible to the blade. $approve is used to determine if the action is to approve the user or not.

    // Filters
    public $remarks, $remarks_event, $remarks_individuals;

    // Search
    public $search_one = '', $search_twopending_admin = '', $search_twodeclined_admin = '', $search_threepending_admin = '', $search_threedeclined_admin = '', $search_one_org = '', $search_twopending_org = '', $search_twodeclined_org = '', $search_one_org_inactive = '';

    // Add Organization Modal Fields
    #[Validate('required')]
    public $organization_name, $date_established, $address;

    #[Validate('required|email:rfc,dns')]
    public $email;

    #[Validate('required|size:11|unique:users,contactNumber')]
    public $contact_number;

    public function render()
    {
        $organization_one = OrganizationInformationModel::orderBy('organization_information.created_at', 'DESC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'organization_information.*') // In my case, I have two different tables and their primary key's name are the same. I put an alias to the id of the other table so that it will distinguish from the other one. his renames the 'name' column from the 'tags' table to 'tag_name' in the result set. This is often done when you have multiple columns with the same name from different tables to avoid naming conflicts. 'products.*': This selects all columns from the 'products' table.
            ->where('status', 1)
            ->search($this->search_one)
            ->paginate(10, pageName: 'registered-organizations'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_two = OrganizationInformationModel::orderBy('organization_information.created_at', 'DESC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'organization_information.*')
            ->where('status', 0)
            ->search($this->search_twopending_admin)
            ->paginate(10, pageName: 'for-approval'); // I'm using multiple paginator in a single blade file. Specifying page name won't affect the other pagination.

        $organization_declined = OrganizationInformationModel::orderBy('users.updated_at', 'ASC')
            ->join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'organization_information.*')
            ->where('status', 2)
            ->search($this->search_twodeclined_admin)
            ->paginate(10, pageName: 'declined-organizations');

        // Once an organization joined an organization from the list of events, it will show here.
        $events = EventOrganizationsModel::join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
            // ->select('event_organizations.id AS org_info_id', 'events.*', 'organization_information.id AS org_id', 'organization_information.*')
            ->select('event_organizations.id AS org_info_id', 'events.id AS events_id', 'events.*', 'organization_information.id AS org_id', 'organization_information.*')
            ->where('event_organizations.status', 0)
            ->orderBy('event_organizations.created_at', 'DESC')
            ->search($this->search_threepending_admin)
            ->paginate(10, pageName: 'event-registrations');

        // Once an organization joined an organization from the list of events and were declined by the admin, it will show here.
        $events_declined = EventOrganizationsModel::join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
            ->select('event_organizations.id AS org_info_id', 'event_organizations.*', 'events.id AS events_id', 'events.*', 'organization_information.id AS org_id', 'organization_information.*')
            ->where('event_organizations.status', 2)
            ->orderBy('event_organizations.created_at', 'DESC')
            ->search($this->search_threedeclined_admin)
            ->paginate(10, pageName: 'declined_events');

        if (Auth::user()->user_id !== 'ADMIN') {
            $individual_one = IndividualInformationModel::orderBy('individual_information.created_at', 'DESC')
                ->where('id_organization', Auth::user()->organization_information->id)
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->select('users.contactNumber AS contact_number', 'individual_information.*')
                ->where('status', 1)
                ->search($this->search_one_org)
                ->paginate(10, pageName: 'total-registered-members');

            $individual_one_inactive = IndividualInformationModel::orderBy('individual_information.created_at', 'DESC')
                ->where('id_organization', Auth::user()->organization_information->id)
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->select('users.contactNumber AS contact_number', 'individual_information.*')
                ->where('status', 3)
                ->search($this->search_one_org_inactive)
                ->paginate(10, pageName: 'total-inactive-members');

            $individual_two = IndividualInformationModel::orderBy('individual_information.created_at', 'DESC')
                ->where('id_organization', Auth::user()->organization_information->id)
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->select('users.contactNumber AS contact_number', 'individual_information.*')
                ->where('status', 0)
                ->search($this->search_twopending_org)
                ->paginate(10, pageName: 'for-approval-members');

            $individual_two_declined = IndividualInformationModel::orderBy('individual_information.created_at', 'DESC')
                ->where('id_organization', Auth::user()->organization_information->id)
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->select('users.contactNumber AS contact_number', 'individual_information.*')
                ->where('status', 2)
                ->search($this->search_twodeclined_org)
                ->paginate(10, pageName: 'declined-members');
        }

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

            'registered_members'            => (Auth::user()->user_id !== 'ADMIN') ? $individual_one : null,
            'currentPageRegisteredMembers'  => (Auth::user()->user_id !== 'ADMIN') ? $individual_one->currentPage() : null,
            'totalPagesRegisteredMembers'   => (Auth::user()->user_id !== 'ADMIN') ? $individual_one->lastPage() : null,
            'totalRecordsRegisteredMembers' => (Auth::user()->user_id !== 'ADMIN') ? $individual_one->total() : null,
            'noRecordsRegisteredMembers'    => (Auth::user()->user_id !== 'ADMIN') ? $individual_one->isEmpty() : null,

            'registered_membersInactive'            => (Auth::user()->user_id !== 'ADMIN') ? $individual_one_inactive : null,
            'currentPageRegisteredMembersInactive'  => (Auth::user()->user_id !== 'ADMIN') ? $individual_one_inactive->currentPage() : null,
            'totalPagesRegisteredMembersInactive'   => (Auth::user()->user_id !== 'ADMIN') ? $individual_one_inactive->lastPage() : null,
            'totalRecordsRegisteredMembersInactive' => (Auth::user()->user_id !== 'ADMIN') ? $individual_one_inactive->total() : null,
            'noRecordsRegisteredMembersInactive'    => (Auth::user()->user_id !== 'ADMIN') ? $individual_one_inactive->isEmpty() : null,

            'for_approval_members'              => (Auth::user()->user_id !== 'ADMIN') ? $individual_two : null,
            'currentPagefor_approval_members'   => (Auth::user()->user_id !== 'ADMIN') ? $individual_two->currentPage() : null,
            'totalPagesfor_approval_members'    => (Auth::user()->user_id !== 'ADMIN') ? $individual_two->lastPage() : null,
            'totalRecordsfor_approval_members'  => (Auth::user()->user_id !== 'ADMIN') ? $individual_two->total() : null,
            'noRecordsfor_approval_members'     => (Auth::user()->user_id !== 'ADMIN') ? $individual_two->isEmpty() : null,

            'declined_members'                   => (Auth::user()->user_id !== 'ADMIN') ? $individual_two_declined : null,
            'currentPagedeclined_members'        => (Auth::user()->user_id !== 'ADMIN') ? $individual_two_declined->currentPage() : null,
            'totalPagesdeclined_members'         => (Auth::user()->user_id !== 'ADMIN') ? $individual_two_declined->lastPage() : null,
            'totalRecordsdeclined_members'       => (Auth::user()->user_id !== 'ADMIN') ? $individual_two_declined->total() : null,
            'noRecordsdeclined_members'          => (Auth::user()->user_id !== 'ADMIN') ? $individual_two_declined->isEmpty() : null,
        ]);
    }

    public function updating()
    {
        $this->resetPage('registered-organizations');
        $this->resetPage('for-approval');
        $this->resetPage('declined-organizations');
        $this->resetPage('event-registrations');
        $this->resetPage('declined_events');

        $this->resetPage('total-registered-members');
        $this->resetPage('for-approval-members');
        $this->resetPage('declined-members');
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

    public function pageOneActive()
    {
        $this->pageone = 'oneActive';
    }

    public function pageOneInactive()
    {
        $this->pageone = 'oneInactive';
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
        $this->approve = true;
        $this->eventID = $event_id;
    }

    public function confirmDeclineEvent($event_id) // Organization's reference ID = $user_id
    {
        $this->approve = false;
        $this->eventID = $event_id;
    }

    public function confirmApproveMember($individual_id) // Organization's reference ID = $user_id
    {
        $this->approve = true;
        $this->individualID = $individual_id;
    }

    public function confirmDeclineMember($individual_id) // Organization's reference ID = $user_id
    {
        $this->approve = false;
        $this->individualID = $individual_id;
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

            // dd($this->remarks);

            $item = User::where('user_id', $userID)->first();
            $item->update([
                'status'    =>      2,
                'remarks'   =>      $this->remarks,
            ]);

            session()->flash('status', 'User declined.');

            // We need to close the modal after the process.
            $this->dispatch('close-modal');
            $this->reset('userID', 'approve', 'remarks');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function approveEvent($eventID)
    {
        if ($eventID) {
            // dd('WEW');
            $item = EventOrganizationsModel::where('id', $eventID)->first();
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
            $item = EventOrganizationsModel::where('id', $eventID)->first();
            $item->update([
                'status'    =>     2,
                'remarks'   =>     $this->remarks_event,
            ]);

            session()->flash('status', 'Event declined');

            $this->dispatch('close-modal3');
            $this->reset('eventID', 'approve', 'remarks_event');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function approveMember($individualID)
    {
        if ($individualID) {
            $item = User::where('user_id', $individualID)->first();
            $item->update([
                'status'    =>     1,
            ]);

            session()->flash('status', 'Member is approved.');

            // We need to close the modal after the process.
            $this->dispatch('close-individualModal');
            $this->reset('individualID', 'approve');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function declineMember($individualID)
    {
        if ($individualID) {

            // dd($this->remarks_individuals);

            $item = User::where('user_id', $individualID)->first();
            $item->update([
                'status'    =>     2,
                'remarks'   =>     $this->remarks_individuals,
            ]);

            session()->flash('status', 'Member is declined.');

            // We need to close the modal after the process.
            $this->dispatch('close-individualModal');
            $this->reset('individualID', 'approve');

            $this->resetPage(pageName: 'registered-organization');
            $this->resetPage(pageName: 'for-approval');
            $this->resetPage(pageName: 'event-registration');
        }
    }

    public function deactivateMember($individualID)
    {
        if ($individualID) {
            $item = User::where('user_id', $individualID)->first();
            $item->update([
                'status'    =>      3,
            ]);

            session()->flash('status', "Rider's status has been set to inactive.");
            $this->reset('individualID');
        }
    }

    public function activateMember($individualID)
    {
        if ($individualID) {
            $item = User::where('user_id', $individualID)->first();
            $item->update([
                'status'    =>      1,
            ]);

            session()->flash('status', "Rider's status has been set to active.");
            $this->reset('individualID');
        }
    }

    public function saveOrg()
    {
        $this->validate();

        // Generate random letters and numbers for user_id
        $timestamp = now()->timestamp;
        $randomString = Str::random(10);
        $user_id = strtoupper($timestamp . $randomString);

        OrganizationInformationModel::create([
            'user_id'           =>  $user_id,
            'organization_name' =>  $this->organization_name,
            'date_established'  =>  $this->date_established,
            'address'           =>  $this->address,
        ]);

        User::create([
            'user_id'                   => $user_id,
            'email'                     => 'null',
            'contactNumber'             => $this->contact_number,
            'id_account_type'           => 1,
            'password'                  => Hash::make('P@ssw0rd'),
            'status'                    => 1,
        ]);

        $this->dispatch('close-registerOrgModal-Modal');
        session()->flash('status', 'Organization added successfully.');
        return redirect()->to('registration');
    }
}
