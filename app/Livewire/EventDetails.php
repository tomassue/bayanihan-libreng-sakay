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
use Livewire\Attributes\Validate;

#[Layout('components.layouts.page')]
#[Title('Event Details')]

class EventDetails extends Component
{
    use WithPagination;

    public $id_event;

    // Modal
    public $approve, $eventID;
    #[Validate('required')]
    public $remarks_event;

    public function render()
    {
        // $event = EventModel::join('event_organizations', 'event_organizations.id_event', '=', 'events.id')
        //     ->join('event_organization_riders', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
        //     ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
        //     ->join('organization_information', 'organization_information.id', '=', 'event_organizations.id_organization')
        //     ->select(
        //         'individual_information.id AS indi_id',
        //         'individual_information.*',
        //         'events.id AS eventID',
        //         'events.*',
        //         'event_organizations.id AS event_organizationsID',
        //         'event_organizations.*',
        //         'event_organization_riders.id AS event_organization_ridersID',
        //         'event_organization_riders.*',
        //         'organization_information.id AS organization_informationID',
        //         'organization_information.*'
        //     )
        //     ->where('event_organizations.id_event', $this->id_event)
        //     ->orderBy('event_organizations.created_at', 'DESC')
        //     ->paginate(10, pageName: 'event-details');

        $event = EventOrganizationsModel::join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
            ->where('id_event', $this->id_event)
            ->where('status', 0)
            ->select(
                'event_organizations.id AS id',
                'organization_information.organization_name'
            )
            ->paginate(10, pageName: 'event-details');

        if (Auth::user()->user_id !== 'ADMIN') {
            $org_event_details = EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
                ->join('events', 'event_organizations.id_event', '=', 'events.id')
                ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
                ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->select(
                    'users.contactNumber AS contact_number',
                    'individual_information.id AS individual_information_id',
                    'individual_information.*',
                    'event_organizations.id AS event_organizations_id',
                    'event_organizations.*',
                    'events.id AS events_id',
                    'events.*',
                    'organization_information.id AS organization_information_id',
                    'organization_information.*'
                )
                ->where('event_organization_riders.id_event_organization', $this->id_event)
                ->orderBy('event_organization_riders.created_at', 'DESC')
                ->paginate(10, pageName: 'organization-event-details');
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

    public function mount($eventID)
    {
        $this->id_event = $eventID;
    }

    public function confirmApproveEvent($event_ID)
    {
        $this->approve = true;
        $this->eventID = $event_ID;
    }

    public function confirmDeclineEvent($event_ID)
    {
        $this->approve = false;
        $this->eventID = $event_ID;
    }

    public function approveEvent($eventID)
    {
        if ($eventID) {
            $item = EventOrganizationsModel::where('id', $eventID)->first();
            if ($item) {
                $item->update([
                    'status'    =>  1
                ]);

                session()->flash('status', 'Event approved.');

                // We need to close the modal after the process.
                $this->dispatch('close-confirmApproveEvent');
                $this->reset('eventID', 'approve');
            }
        }
    }

    public function declineEvent($eventID)
    {
        $this->validate();
        if ($eventID) {
            $item = EventOrganizationsModel::where('id', $eventID)->first();
            if ($item) {
                $item->update([
                    'status'    =>  2,
                    'remarks'   =>  $this->remarks_event
                ]);

                session()->flash('status', 'Event declined.');

                // We need to close the modal after the process.
                $this->dispatch('close-confirmDeclineEvent');
                $this->reset('eventID', 'approve');
            }
        }
    }
}
