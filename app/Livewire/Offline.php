<?php

namespace App\Livewire;

use Livewire\Component;

class Offline extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div wire:offline>
            <li class="nav-item dropdown pe-3">
                <span class="badge bg-danger">Whoops, your device has lost connection. The web page you are viewing is offline.</span>
            </li>
        </div>
        HTML;
    }
}
