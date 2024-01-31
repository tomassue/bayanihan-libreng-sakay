<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Event Details')]

class EventDetails extends Component
{
    use WithPagination;

    public EventModel $id_event;

    public function render()
    {
        $event = EventModel::join('event_organizations', 'event_organizations.id_event', '=', 'events.id')
            ->join('event_organization_riders', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
            ->where('event_organizations.id_event', $this->id_event['id'])
            ->paginate(5, pageName: 'event-details');

        return view('livewire.event-details', [
            'event'            =>      $event,
            'currentPage'      =>      $event->currentPage(),
            'totalPages'       =>      $event->lastPage(),
            'totalRecords'     =>      $event->total(),
            'noRecords'        =>      $event->isEmpty(),
        ]);
    }

    public function mount(EventModel $eventID)
    {
        $this->id_event = $eventID;
    }
}
