<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.page')]
#[Title('Registration')]
class Registration extends Component
{
    public function render()
    {
        return view('livewire.registration');
    }
}
