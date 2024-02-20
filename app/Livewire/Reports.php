<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.page')]
#[Title('Dashboard')]

class Reports extends Component
{
    public function render()
    {
        return view('livewire.reports');
    }
}
