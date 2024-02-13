<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

use App\Models\OrganizationInformationModel;
use App\Models\IndividualInformationModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.page')]
#[Title('Dashboard')]

class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        $organization_information = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->join('account_type', 'users.id_account_type', '=', 'account_type.id')
            ->select('organization_information.*', 'account_type.id AS account_type.id', 'account_type.account_type_name')
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if (Auth::user()->user_id !== 'ADMIN') {
            $individual_information = IndividualInformationModel::where('id_organization', Auth::user()->organization_information->id)
                ->join('users', 'individual_information.user_id', '=', 'users.user_id')
                ->where('status', 1)
                ->join('account_type', 'users.id_account_type', '=', 'account_type.id')
                ->select('individual_information.*', 'account_type.id AS account_type.id', 'account_type.account_type_name')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('livewire.dashboard', [
            'organization_information' => $organization_information,
            'individual_information'   => (Auth::user()->user_id !== 'ADMIN') ? $individual_information : null,
        ]);
    }
}
