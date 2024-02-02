<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use App\Models\EventOrganizationRidersModel;

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
            ->join('organization_information', 'organization_information.id', '=', 'event_organizations.id_organization')
            ->where('event_organizations.id_event', $this->id_event['id'])
            ->paginate(5, pageName: 'event-details');

        if (Auth::user()->user_id !== 'ADMIN') {
            $org_event_details = EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                ->join('events', 'event_organizations.id_event', '=', 'events.id')
                ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
                ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
                ->select('individual_information.contact_number AS indi_contact_number', 'event_organizations.*', 'events.*', 'organization_information.*', 'individual_information.*')
                ->where('event_organizations.id_organization', Auth::user()->organization_information->id)
                ->paginate(5, pageName: 'organization-event-details');
        }

        return view('livewire.event-details', [
            'event'            =>      $event,
            'currentPage'      =>      $event->currentPage(),
            'totalPages'       =>      $event->lastPage(),
            'totalRecords'     =>      $event->total(),
            'noRecords'        =>      $event->isEmpty(),

            'org_event_details'                 => (Auth::user()->user_id !== 'ADMIN') ? $org_event_details : null,
            'currentPageorg_event_details'      => (Auth::user()->user_id !== 'ADMIN') ? $org_event_details->currentPage() : null,
            'totalPagesorg_event_details'       => (Auth::user()->user_id !== 'ADMIN') ? $org_event_details->lastPage() : null,
            'totalRecordsorg_event_details'     => (Auth::user()->user_id !== 'ADMIN') ? $org_event_details->total() : null,
            'noRecordsorg_event_details'        => (Auth::user()->user_id !== 'ADMIN') ? $org_event_details->isEmpty() : null,
        ]);
    }

    public function mount(EventModel $eventID)
    {
        $this->id_event = $eventID;
    }
}
