<?php

namespace App\Livewire\SidebarNotificationIndicators;

use Livewire\Component;

class RegistrationNotificationIndicator extends Component
{
    public function render()
    {
        return <<<'HTML'
        <div wire:poll.5s>
        @php
        if(Auth::user()->user_id !== 'ADMIN') {
        $org_for_approval = App\Models\IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
        ->join('users', 'individual_information.user_id', 'users.user_id')
        ->where('status', 0)
        ->count();
        } else {
        $admin_for_approval = App\Models\OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
        ->where('status', 0)
        ->count();
        $admin_event_registration = App\Models\EventOrganizationsModel::where('status', 0)
        ->count();
        $org_event_registration = App\Models\EventOrganizationsModel::where('status', 0)
        ->count();
        }
        @endphp

        @if(Auth::user()->user_id !== 'ADMIN')
        @if($org_for_approval > 0)
        <span>
            <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
        </span>
        @endif
        @else
        @if($admin_for_approval > 0 || $admin_event_registration > 0 || $org_event_registration > 0)
        <span>
            <i class="bi bi-circle-fill" style="color: #dc3545;"></i>
        </span>
        @endif
        @endif
        </div>
        HTML;
    }
}
