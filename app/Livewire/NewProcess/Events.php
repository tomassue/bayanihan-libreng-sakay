<?php

namespace App\Livewire\NewProcess;

use App\Models\ClientInformationModel;
use App\Models\ClientRiderTaggingModel;
use App\Models\EventModel;
use App\Models\IndividualInformationModel;
use App\Models\NumberMessageModel;
use App\Models\SmsSenderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Number;

#[Layout('components.layouts.page')]
#[Title('Events')]
class Events extends Component
{
    use WithPagination;

    public $event_name;
    public $event_date;
    public $event_location;
    public $google_map_link;
    public $time_start;
    public $time_end;
    public $category;
    public $estimated_number_of_participants;

    /* --------------------------------- TAGGING -------------------------------- */

    public $selected_tags = [];
    public $select_all = false;
    public $id_event;
    public $id_client;
    public $id_individual;

    public function render()
    {
        $loadEvents = $this->loadEvents();

        $data = [
            'events' => $loadEvents['events'],
            'total_no_of_events' => $loadEvents['total_no_of_events'],
            'ongoing' => $loadEvents['ongoing'],
            'done' => $loadEvents['done'],
            'tags' => $this->loadTags(),
            'clients' => $this->loadClients(), // Client-select
            'riders' => $this->loadRiders() // Rider-select
        ];

        return view('livewire.new-process.events', $data);
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

    public function rules()
    {
        return [
            'event_name' => 'required',
            'event_date' => 'required',
            'event_location' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'category' => 'required',
            'estimated_number_of_participants' => 'required'
        ];
    }

    public function updated($property)
    {
        if ($property === 'select_all') {
            if ($this->select_all) {
                // If select_all is true (checkbox is checked), select all tags
                $this->selected_tags = $this->loadTags()->pluck('id')->toArray(); // Assuming tags are Eloquent models
            } else {
                // If select_all is false (checkbox is unchecked), deselect all tags
                $this->selected_tags = [];
            }
        }
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function add()
    {
        $this->validate($this->rules());

        $check_duplicates = EventModel::where('event_name', $this->event_name)
            ->where('event_date', $this->event_date)
            ->exists();

        if (!$check_duplicates) {
            try {
                DB::beginTransaction();

                EventModel::create([
                    'event_name' => $this->event_name,
                    'event_date' => $this->event_date,
                    'event_location' => $this->event_location,
                    'google_map_link' => $this->google_map_link,
                    'time_start' => $this->time_start,
                    'time_end' => $this->time_end,
                    'category' => $this->category,
                    'estimated_number_of_participants' => $this->estimated_number_of_participants,
                    'status' => '1'
                ]);

                DB::commit();

                $this->dispatch('hide_eventSaveModal');
                $this->reset();
                $this->dispatch('success_save');
            } catch (\Exception $e) {
                DB::rollBack();

                dd($e->getMessage());
            }
        } else {
            $this->dispatch('duplicate_entry');
        }
    }

    #[On('tag')]
    public function tag()
    {
        $rules = [
            'id_client' => 'required',
            'id_individual' => 'required'
        ];

        $attributes = [
            'id_client' => 'client',
            'id_individual' => 'rider'
        ];

        $this->validate($rules, [], $attributes);

        try {
            $check_duplicate_tag = ClientRiderTaggingModel::where('id_event', $this->id_event)->where('id_client', $this->id_client)->where('id_individual', $this->id_individual)->exists();

            if (!$check_duplicate_tag) {
                DB::beginTransaction();

                ClientRiderTaggingModel::create([
                    'id_event' => $this->id_event,
                    'id_client' => $this->id_client,
                    'id_individual' => $this->id_individual
                ]);

                $this->dispatch('reset_plugins');
                $this->dispatch('success_save');

                DB::commit();
            } else {
                DB::rollBack();

                $this->dispatch('duplicate_entry');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('something_went_wrong');
        }
    }

    // When sending a Message for only one record
    public function sendMessage($id)
    {
        try {
            // Start transaction before the loop
            DB::beginTransaction();

            $info = ClientRiderTaggingModel::join('client_information', 'client_information.user_id', '=', 'client_rider_tagging.id_client')
                ->join('individual_information', 'individual_information.user_id', '=', 'client_rider_tagging.id_individual')
                ->where('client_rider_tagging.id', $id)
                ->select(
                    'client_information.guardian_contact_number',
                    DB::raw("
                    CONCAT(
                        client_information.first_name, ' ',
                        COALESCE(client_information.middle_name, ''), '. ',
                        client_information.last_name, 
                        IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')
                    ) AS client_full_name
                "),
                    DB::raw("
                    CONCAT(
                        individual_information.first_name, ' ',
                        COALESCE(individual_information.middle_name, ''), '. ',
                        individual_information.last_name, 
                        IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')
                    ) AS rider_full_name
                ")
                )
                ->get();

            foreach ($info as $item) {
                // Define common variables outside of the object creation to use later
                $message = "BAYANIHAN LIBRENG SAKAY INFO: " . "\n\nSi " . $item->client_full_name . " ay nag-avail ng Libreng Sakay. Ang kaniyang rider ay si " . $item->rider_full_name . ".";
                $trans_id = time() . '-' . mt_rand();

                // Save SMS data
                $sms = new SmsSenderModel();
                $sms->trans_id = $trans_id;
                $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-NOTIFICATION";
                $sms->recipient = $item->guardian_contact_number;
                $sms->recipient_message = $message . ' ' . "\n\n**This is a system-generated message. Please DO NOT REPLY.**";
                $sms->save(); // If this fails, it will throw an exception and rollback

                // Save Blaster data
                $blaster = new NumberMessageModel();
                $blaster->user_id = $id;
                $blaster->phone_number = $item->guardian_contact_number;
                $blaster->sms_trans_id = $trans_id;
                $blaster->otp_type = "BAYANIHAN-LIBRENG-SAKAY-NOTIFICATION";
                $blaster->sms_status = "STATUS";
                $blaster->save(); // If this fails, it will also rollback

                // Update the tagging model to mark the message as sent
                ClientRiderTaggingModel::where('id', $id)
                    ->update(['is_message_sent' => 1]); // If this fails, it will rollback
            }

            // Commit the transaction after the loop
            DB::commit();

            $this->dispatch('success_save');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();

            // Debug the error and notify
            dd($e->getMessage());
            $this->dispatch('something_went_wrong');
        }
    }

    public function sendMessageToMany()
    {
        try {
            DB::beginTransaction();

            foreach ($this->selected_tags as $tag) {
                $info = ClientRiderTaggingModel::join('client_information', 'client_information.user_id', '=', 'client_rider_tagging.id_client')
                    ->join('individual_information', 'individual_information.user_id', '=', 'client_rider_tagging.id_individual')
                    ->where('client_rider_tagging.id', $tag)
                    ->select(
                        'client_information.guardian_contact_number',
                        DB::raw("
                    CONCAT(
                        client_information.first_name, ' ',
                        COALESCE(client_information.middle_name, ''), '. ',
                        client_information.last_name, 
                        IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')
                    ) AS client_full_name
                "),
                        DB::raw("
                    CONCAT(
                        individual_information.first_name, ' ',
                        COALESCE(individual_information.middle_name, ''), '. ',
                        individual_information.last_name, 
                        IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')
                    ) AS rider_full_name
                ")
                    )
                    ->get();

                foreach ($info as $item) {
                    // Define common variables outside of the object creation to use later
                    $message = "BAYANIHAN LIBRENG SAKAY INFO: " . "\n\nSi " . $item->client_full_name . " ay nag-avail ng Libreng Sakay. Ang kaniyang rider ay si " . $item->rider_full_name . ".";
                    $trans_id = time() . '-' . mt_rand();

                    // Save SMS data
                    $sms = new SmsSenderModel();
                    $sms->trans_id = $trans_id;
                    $sms->received_id = "BAYANIHAN-LIBRENG-SAKAY-NOTIFICATION";
                    $sms->recipient = $item->guardian_contact_number;
                    $sms->recipient_message = $message . ' ' . "\n\n**This is a system-generated message. Please DO NOT REPLY.**";
                    $sms->save(); // If this fails, it will throw an exception and rollback

                    // Save Blaster data
                    $blaster = new NumberMessageModel();
                    $blaster->user_id = $tag;
                    $blaster->phone_number = $item->guardian_contact_number;
                    $blaster->sms_trans_id = $trans_id;
                    $blaster->otp_type = "BAYANIHAN-LIBRENG-SAKAY-NOTIFICATION";
                    $blaster->sms_status = "STATUS";
                    $blaster->save(); // If this fails, it will also rollback

                    // Update the tagging model to mark the message as sent
                    ClientRiderTaggingModel::where('id', $tag)
                        ->update(['is_message_sent' => 1]); // If this fails, it will rollback
                }
            }

            DB::commit();

            $this->dispatch('success_save');
            $this->reset('selected_tags');
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('something-went-wrong');
        }
    }

    // This method will be called whenever selected_tags is updated
    public function updatedSelectedTags()
    {
        // Check if all tags are selected, if not, uncheck the "select all" checkbox
        $this->select_all = count($this->selected_tags) === $this->loadTags()->count();
    }

    public function details($id)
    {
        try {
            $event = EventModel::findOrFail($id);
            $this->event_name = $event->event_name;
            $this->id_event = $id;

            $this->dispatch('show_eventDetailsModal');
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->dispatch('something_went_wrong');
        }
    }

    public function loadEvents()
    {
        $events = EventModel::where('status', 1)
            ->where('tag', 0)
            ->select(
                'id',
                'event_name',
                DB::raw("
                    DATE_FORMAT(
                        event_date, '%b %d, %Y'
                    ) AS event_date
                ")
            )
            ->orderBy('event_date', 'asc')
            ->paginate(10);

        foreach ($events as $event) {
            $event->client_served_count = ClientRiderTaggingModel::where('id_event', $event->id)->count();
        }

        $total_no_of_events = EventModel::all()->count();
        $ongoing = EventModel::whereDate('event_date', Carbon::today())->count();
        $done = EventModel::where('tag', 1)->count();

        return [
            'events' => $events,
            'total_no_of_events' => $total_no_of_events,
            'ongoing' => $ongoing,
            'done' => $done
        ];
    }

    public function loadTags()
    {
        $tags = ClientRiderTaggingModel::join('client_information', 'client_information.user_id', '=', 'client_rider_tagging.id_client')
            ->join('individual_information', 'individual_information.user_id', '=', 'client_rider_tagging.id_individual')
            ->select(
                'client_rider_tagging.id',
                // 'tbl_number_messages.sms_trans_id',
                DB::raw("
                    CONCAT(
                        client_information.first_name, ' ',
                        COALESCE(client_information.middle_name, ''), ' ',
                        client_information.last_name, 
                        IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')
                    ) AS client_full_name
                "),
                DB::raw("
                    CONCAT(
                        individual_information.first_name, ' ',
                        COALESCE(individual_information.middle_name, ''), ' ',
                        individual_information.last_name, 
                        IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')
                    ) AS individual_full_name
                "),
                DB::raw("
                    CASE
                        WHEN client_rider_tagging.is_message_sent = '0' THEN 'pending'
                        WHEN client_rider_tagging.is_message_sent = '1' THEN 'sent'
                    END AS message_status
                "),
                DB::raw("
                    DATE_FORMAT(client_rider_tagging.created_at, '%h:%i %p') AS time
                ")
            )
            ->where('id_event', $this->id_event)
            ->orderBy('client_rider_tagging.created_at', 'desc')
            ->paginate(10, pageName: 'tags');

        return $tags;
    }

    public function loadClients()
    {
        $clients = ClientInformationModel::join('tbl_ref_barangay', 'tbl_ref_barangay.id', '=', 'client_information.id_barangay')
            ->select(
                'client_information.user_id',
                DB::raw("
                CONCAT(
                    client_information.first_name,
                    ' ',
                    COALESCE(client_information.middle_name, ''),
                    ' ',
                    client_information.last_name,
                    IF(TRIM(IFNULL(client_information.ext_name, '')) != '', CONCAT(', ', client_information.ext_name), '')
                ) AS full_name
            "),
                'tbl_ref_barangay.barangay',
                DB::raw("
                CASE
                    WHEN client_information.user_type = 'student' THEN 'Student'
                    WHEN client_information.user_type = 'school_staff' THEN 'School Staff'
                    WHEN client_information.user_type = 'city_hall_employee' THEN 'City Hall Employee'
                    WHEN client_information.user_type = 'city_hall_client' THEN 'City Hall Client'
                    WHEN client_information.user_type = 'other' THEN 'Other'
                    ELSE ''
                END AS user_type
            ")
            )
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->full_name . ' ' . '(' . $item->user_type . ')',
                    'value' => $item->user_id,
                    'description' => $item->barangay
                ];
            });

        return $clients;
    }

    public function loadRiders()
    {
        $riders = IndividualInformationModel::join('tbl_ref_barangay', 'tbl_ref_barangay.id', '=', 'individual_information.id_barangay')
            ->join('organization_information', 'organization_information.id', '=', 'individual_information.id_organization')
            ->select(
                'individual_information.user_id',
                DB::raw("
                CONCAT(
                    individual_information.first_name,
                    ' ',
                    COALESCE(individual_information.middle_name, ''),
                    ' ',
                    individual_information.last_name,
                    IF(TRIM(IFNULL(individual_information.ext_name, '')) != '', CONCAT(', ', individual_information.ext_name), '')
                ) AS full_name
            "),
                'tbl_ref_barangay.barangay',
                'organization_information.organization_name'
            )
            ->get()
            ->map(
                function ($item) {
                    return [
                        'label' => $item->full_name . ' ' . '(' . $item->organization_name . ')',
                        'value' => $item->user_id,
                        'description' => $item->barangay
                    ];
                }
            );

        return $riders;
    }
}
