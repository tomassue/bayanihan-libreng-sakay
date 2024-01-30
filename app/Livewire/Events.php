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

    public function render()
    {
        /**
         * LIST OF EVENTS (Organization)
         * It filters out events that have corresponding records in the event_organizations table with the specified conditions, 
         * which exclude events associated with the organization of the currently authenticated user.
         */
        $listOfEvents = EventModel::where('status', 1)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('event_organizations')
                    ->whereRaw('event_organizations.id_event = events.id');

                if (Auth::user()->user_id !== 'ADMIN') {
                    $query->whereRaw('event_organizations.id_organization = ?', [Auth::user()->organization_information->id]);
                }
            })
            ->paginate(5, ['*'], pageName: 'total-events');
        /**END LIST OF EVENTS */

        $totalNoOfEvents = EventModel::all();

        return view('livewire.events', [
            'listOfEvents'                      =>      $listOfEvents,
            'currentPageOnelistOfEvents'        =>      $listOfEvents->currentPage(),
            'totalPagesOnelistOfEvents'         =>      $listOfEvents->lastPage(),
            'totalRecordsOnelistOfEvents'       =>      $listOfEvents->total(),
            'noRecordsOnelistOfEvents'          =>      $listOfEvents->isEmpty(),
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
