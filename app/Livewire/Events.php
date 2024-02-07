<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout('components.layouts.page')]
#[Title('Events')]

class Events extends Component
{
    use WithPagination;

    // FILTER
    public $filter, $approve, $join;

    #[Locked]
    public $event_ID;

    // Input fields
    #[Validate('required')]
    public $eventName, $eventDate;

    // Search
    public $search_totalNoOfEvents_admin = '', $search_onGoingEvents_admin = '', $search_doneEvents_admin = '', $search_totalNoOfEvents_org = '', $search_listOfEvents_org = '', $search_onGoingEvents_org = '', $search_doneEvents_org = '';

    public function render()
    {
        /** ORGANIZATION */
        if (Auth::user()->user_id !== 'ADMIN') {
            $totalNoOfEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->join('events', 'events.id', '=', 'event_organizations.id_event')
                ->select('event_organizations.id AS event_organizations_id', 'events.*')
                ->search($this->search_totalNoOfEvents_org)
                ->paginate(5, pageName: 'organization-total-no-of-events');

            /**
             * LIST OF EVENTS (FOR Organization)
             * It filters out events that have corresponding records in the event_organizations table with the specified conditions, 
             * which exclude events associated with the organization of the currently authenticated user.
             */
            $listOfEvents = EventModel::where('status', 1)
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('event_organizations')
                        ->whereRaw('event_organizations.id_event = events.id');
                    $query->whereRaw('event_organizations.id_organization = ?', [Auth::user()->organization_information->id]);
                })
                ->search($this->search_listOfEvents_org)
                ->paginate(5, ['*'], pageName: 'list-of-events');

            $onGoingEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->join('events', 'events.id', '=', 'event_organizations.id_event')
                ->where('events.tag', 0)
                ->select('event_organizations.id AS event_organizations_id', 'events.*')
                ->search($this->search_onGoingEvents_org)
                ->paginate(5, pageName: 'organization-ongoing-events');

            $doneEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->join('events', 'events.id', '=', 'event_organizations.id_event')
                ->where('events.tag', 1)
                ->select('event_organizations.id AS event_organizations_id', 'events.*')
                ->search($this->search_doneEvents_org)
                ->paginate(5, pageName: 'organization-ongoing-events');
        }
        /** END ORGANIZATION */

        /** ADMINISTRATION */
        $totalNoOfEvents = EventModel::search($this->search_totalNoOfEvents_admin)
            ->paginate(5, pageName: 'total-no-of-events');

        $onGoingEvents = EventModel::where('tag', 0)
            ->search($this->search_onGoingEvents_admin)
            ->paginate(5, pageName: 'ongoing-events');

        $doneEvents = EventModel::where('tag', 1)
            ->search($this->search_doneEvents_admin)
            ->paginate(5, pageName: 'done-events');
        /** END ADMINISTRATION */

        return view('livewire.events', [
            // ORGANIZATION
            'totalNoOfEvents_org'                      => (Auth::user()->user_id !== 'ADMIN') ? $totalNoOfEvents_org : null,
            'currentPageOnetotalNoOfEvents_org'        => (Auth::user()->user_id !== 'ADMIN') ? $totalNoOfEvents_org->currentPage() : null,
            'totalPagesOnetotalNoOfEvents_org'         => (Auth::user()->user_id !== 'ADMIN') ? $totalNoOfEvents_org->lastPage() : null,
            'totalRecordsOnetotalNoOfEvents_org'       => (Auth::user()->user_id !== 'ADMIN') ? $totalNoOfEvents_org->total() : null,
            'noRecordsOnetotalNoOfEvents_org'          => (Auth::user()->user_id !== 'ADMIN') ? $totalNoOfEvents_org->isEmpty() : null,

            'listOfEvents'                      => (Auth::user()->user_id !== 'ADMIN') ? $listOfEvents : null,
            'currentPageOnelistOfEvents'        => (Auth::user()->user_id !== 'ADMIN') ? $listOfEvents->currentPage() : null,
            'totalPagesOnelistOfEvents'         => (Auth::user()->user_id !== 'ADMIN') ? $listOfEvents->lastPage() : null,
            'totalRecordsOnelistOfEvents'       => (Auth::user()->user_id !== 'ADMIN') ? $listOfEvents->total() : null,
            'noRecordsOnelistOfEvents'          => (Auth::user()->user_id !== 'ADMIN') ? $listOfEvents->isEmpty() : null,

            'onGoingEvents_org'                      => (Auth::user()->user_id !== 'ADMIN') ? $onGoingEvents_org : null,
            'currentPageOneonGoingEvents_org'        => (Auth::user()->user_id !== 'ADMIN') ? $onGoingEvents_org->currentPage() : null,
            'totalPagesOneonGoingEvents_org'         => (Auth::user()->user_id !== 'ADMIN') ? $onGoingEvents_org->lastPage() : null,
            'totalRecordsOneonGoingEvents_org'       => (Auth::user()->user_id !== 'ADMIN') ? $onGoingEvents_org->total() : null,
            'noRecordsOneonGoingEvents_org'          => (Auth::user()->user_id !== 'ADMIN') ? $onGoingEvents_org->isEmpty() : null,

            'doneEvents_org'                      => (Auth::user()->user_id !== 'ADMIN') ? $doneEvents_org : null,
            'currentPageOnedoneEvents_org'        => (Auth::user()->user_id !== 'ADMIN') ? $doneEvents_org->currentPage() : null,
            'totalPagesOnedoneEvents_org'         => (Auth::user()->user_id !== 'ADMIN') ? $doneEvents_org->lastPage() : null,
            'totalRecordsOnedoneEvents_org'       => (Auth::user()->user_id !== 'ADMIN') ? $doneEvents_org->total() : null,
            'noRecordsOnedoneEvents_org'          => (Auth::user()->user_id !== 'ADMIN') ? $doneEvents_org->isEmpty() : null,
            // END ORGANIZATION

            // ADMINISTRATION
            'totalNoOfEvents'                   =>      $totalNoOfEvents,
            'currentPagetotalNoOfEvents'        =>      $totalNoOfEvents->currentPage(),
            'totalPagestotalNoOfEvents'         =>      $totalNoOfEvents->lastPage(),
            'totalRecordstotalNoOfEvents'       =>      $totalNoOfEvents->total(),
            'noRecordstotalNoOfEvents'          =>      $totalNoOfEvents->isEmpty(),

            'onGoingEvents'                   =>      $onGoingEvents,
            'currentPageonGoingEvents'        =>      $onGoingEvents->currentPage(),
            'totalPagesonGoingEvents'         =>      $onGoingEvents->lastPage(),
            'totalRecordsonGoingEvents'       =>      $onGoingEvents->total(),
            'noRecordsonGoingEvents'          =>      $onGoingEvents->isEmpty(),

            'doneEvents'                   =>      $doneEvents,
            'currentPagedoneEvents'        =>      $doneEvents->currentPage(),
            'totalPagesdoneEvents'         =>      $doneEvents->lastPage(),
            'totalRecordsdoneEvents'       =>      $doneEvents->total(),
            'noRecordsdoneEvents'          =>      $doneEvents->isEmpty(),
            // END ADMINISTRATION
        ]);
    }

    // This method will refresh the page to page one when we update the table like search.
    public function updating()
    {
        $this->resetPage('total-no-of-events');
        $this->resetPage('ongoing-events');
        $this->resetPage('done-events');

        $this->resetPage('organization-total-no-of-events');
        $this->resetPage('list-of-events');
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

    public function pageFour() // This page will only appear for the organization. Here, they'll see events that they can join.
    {
        $this->filter = 'four';
    }

    public function save()
    {
        $this->validate();

        $checkExistingRecord = EventModel::where('event_name', $this->eventName)
            ->where('event_date', $this->eventDate)
            ->first();

        // dd($checkExistingRecord);
        if ($checkExistingRecord) {
            $this->addError('eventName', 'Duplicate record found for the given event name and date.'); // addError() will propagate the messsage to @error().
            $this->addError('eventDate', 'Duplicate record found for the given event name and date.');
        } else {
            EventModel::create([
                'event_name'    =>      $this->eventName,
                'event_date'    =>      $this->eventDate,
            ]);

            $this->reset('eventName', 'eventDate');
            $this->dispatch('close-eventSave-Modal');
            session()->flash('status', 'Event added successfully.');
        }
    }

    public function confirmJoinEvent($id)
    {
        $this->event_ID = $id;
        $this->join = true;
    }

    public function joinEvent($event_ID)
    {
        if ($event_ID) {
            EventOrganizationsModel::create([
                'id_event' => $event_ID,
                'id_organization' => (Auth::user()->user_id !== 'ADMIN') ? Auth::user()->organization_information->id : null,
            ]);

            $this->reset('event_ID');
            $this->dispatch('close-confirmJoin-Modal');
            session()->flash('status', 'Joined successfully.');
        }
    }
}
