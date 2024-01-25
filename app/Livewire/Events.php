<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use App\Models\EventModel;

#[Layout('components.layouts.page')]
#[Title('Events')]
class Events extends Component
{
    // FILTER
    public $filter;

    // Input fields
    #[Validate('required')]
    public $eventName;
    #[Validate('required')]
    public $eventDate;

    public function render()
    {
        $data = EventModel::all();

        return view('livewire.events', [
            'event'    =>      $data,
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
}
