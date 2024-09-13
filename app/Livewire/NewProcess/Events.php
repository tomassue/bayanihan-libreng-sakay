<?php

namespace App\Livewire\NewProcess;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('Events')]
class Events extends Component
{
    public function render()
    {
        return view('livewire.new-process.events');
    }
}
