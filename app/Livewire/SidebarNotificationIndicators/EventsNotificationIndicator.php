<?php

namespace App\Livewire\SidebarNotificationIndicators;

use Livewire\Component;

class EventsNotificationIndicator extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div wire:poll.5s>
        @php
        if(Auth::user()->user_id !== 'ADMIN') {
        $org_list_of_events = App\Models\EventModel::where('status', 1)
        ->where('tag', 0)
        ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
        ->from('event_organizations')
        ->whereRaw('event_organizations.id_event = events.id');
        $query->whereRaw('event_organizations.id_organization = ?', [Auth::user()->organization_information->id]);
        })
        ->count();
        }
        @endphp

        @if(Auth::user()->user_id !== 'ADMIN')
        @if($org_list_of_events > 0)
        <span class="ms-auto">
            <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
        </span>
        @endif
        @endif
        </div>
        HTML;
    }
}
