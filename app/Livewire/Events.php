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
    public  $google_map_link;

    #[Validate('required')]
    public $eventName, $event_location, $time_start, $time_end, $category, $estimated_number_of_participants;

    #[Validate('required|date|after_or_equal:today')]
    public $eventDate;

    // Search
    public $search_totalNoOfEvents_admin = '', $search_onGoingEvents_admin = '', $search_doneEvents_admin = '', $search_totalNoOfEvents_org = '', $search_listOfEvents_org = '', $search_onGoingEvents_org = '', $search_doneEvents_org = '';

    public function render()
    {
        /** ORGANIZATION */
        if (Auth::user()->user_id !== 'ADMIN') {
            // $totalNoOfEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
            //     ->where('event_organizations.status', 1)
            //     ->join('events', 'events.id', '=', 'event_organizations.id_event')
            //     ->select('event_organizations.id AS event_organizations_id', 'event_organizations.id_event', 'events.*')
            //     ->orderBy('events.created_at', 'DESC')
            //     ->search($this->search_totalNoOfEvents_org)
            //     ->paginate(10, pageName: 'organization-total-no-of-events');

            $totalNoOfEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->join('events', 'event_organizations.id_event', '=', 'events.id')
                ->select(
                    'event_organizations.id AS event_organizations_id',
                    'events.id AS events_id',
                    'events.event_name AS event_name',
                    'events.event_date AS event_date',
                )
                ->paginate(10, pageName: 'organization-total-no-of-events');

            /**
             * LIST OF EVENTS (FOR Organization)
             * It filters out events that have corresponding records in the event_organizations table with the specified conditions, 
             * which exclude events associated with the organization of the currently authenticated user.
             */
            $listOfEvents = EventModel::where('status', 1)
                ->where('tag', 0)
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('event_organizations')
                        ->whereRaw('event_organizations.id_event = events.id');
                    $query->whereRaw('event_organizations.id_organization = ?', [Auth::user()->organization_information->id]);
                })
                ->orderBy('events.created_at', 'DESC')
                ->search($this->search_listOfEvents_org)
                ->paginate(10, ['*'], pageName: 'list-of-events');

            // ON-GOING or UPCOMING
            $onGoingEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->where('event_organizations.status', 1)
                ->join('events', 'events.id', '=', 'event_organizations.id_event')
                ->where('events.tag', 0)
                ->select('event_organizations.id AS event_organizations_id', 'events.*')
                ->orderBy('events.created_at', 'DESC')
                ->search($this->search_onGoingEvents_org)
                ->paginate(10, pageName: 'organization-ongoing-events');

            $doneEvents_org = EventOrganizationsModel::where('id_organization', [Auth::user()->organization_information->id])
                ->join('events', 'events.id', '=', 'event_organizations.id_event')
                ->where('events.tag', 1)
                ->select('event_organizations.id AS event_organizations_id', 'events.*')
                ->orderBy('events.created_at', 'DESC')
                ->search($this->search_doneEvents_org)
                ->paginate(10, pageName: 'organization-ongoing-events');
        }
        /** END ORGANIZATION */

        /** ADMINISTRATION */
        $totalNoOfEvents = EventModel::search($this->search_totalNoOfEvents_admin)
            ->orderBy('created_at', 'DESC')
            ->paginate(10, pageName: 'total-no-of-events');

        $onGoingEvents = EventModel::where('tag', 0)
            ->orderBy('created_at', 'DESC')
            ->search($this->search_onGoingEvents_admin)
            ->paginate(10, pageName: 'ongoing-events');

        $doneEvents = EventModel::where('tag', 1)
            ->orderBy('created_at', 'DESC')
            ->search($this->search_doneEvents_admin)
            ->paginate(10, pageName: 'done-events');
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
        // dd($this->time_start, $this->time_end);
        $this->validate();

        $checkExistingRecord = EventModel::where('event_name', $this->eventName)
            ->where('event_date', $this->eventDate)
            ->where('tag', 0)
            ->first();

        // dd($checkExistingRecord);
        if ($checkExistingRecord) {
            $this->addError('eventName', 'Duplicate record found for the given event name and date.'); // addError() will propagate the messsage to @error().
            $this->addError('eventDate', 'Duplicate record found for the given event name and date.');
        } else {
            EventModel::create([
                'event_name'                        => $this->eventName,
                'event_date'                        => $this->eventDate,
                'event_location'                    => $this->event_location,
                'google_map_link'                   => $this->google_map_link,
                'time_start'                        => $this->time_start,
                'time_end'                          => $this->time_end,
                'category'                          => $this->category,
                'estimated_number_of_participants'  => $this->estimated_number_of_participants,
            ]);

            $this->dispatch('close-eventSave-Modal');
            session()->flash('status', 'Event added successfully.');
            return redirect()->to('events');
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

    // I have this condition that when the events are past due, we need to update the event and set it as done.
    public function boot()
    {
        /**
         *  whereDate('event_date', '<', now()->toDateString()): This condition filters the records where the event_date is less than today's date (now()->toDateString() returns today's date in the format YYYY-MM-DD). 
         *  This will exclude events that are scheduled for today. This query will fetch all records where the event_date is in the past, excluding today's date.
         */
        $pastDueRecords = EventModel::where('event_date', '<', now()->toDateString());
        $pastDueRecords->update([
            'tag'   =>  1,
        ]);
    }
}
