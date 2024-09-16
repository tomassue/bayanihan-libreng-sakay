<?php

namespace App\Livewire\NewProcess;

use App\Models\EventModel;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function render()
    {
        $data = [
            'events' => $this->loadEvents()
        ];

        return view('livewire.new-process.events', $data);
    }

    // I have this condition that when the events are past due, we need to update the event and set it as done.
    public function boot()
    {
        $this->dispatch('show_eventDetailsModal'); //NOTE - SHowing the modal upon boot. FOR DEVELOPMENT PURPOSES!

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

    public function details($id)
    {

        $this->dispatch('show_eventDetailsModal');
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
            ->orderBy('event_date', 'desc')
            ->paginate(10);

        return $events;
    }
}
