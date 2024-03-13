<?php

namespace App\Livewire;

use App\Models\IndividualInformationModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('components.layouts.page')]
#[Title('Riders Reports')]
class IndiReports extends Component
{
    use WithPagination;

    public function render()
    {
        $auth_org_id = Auth::user()->organization_information->id;

        $riders = IndividualInformationModel::where('id_organization', $auth_org_id)
            ->select(
                'id',
                DB::raw("CONCAT(COALESCE(last_name, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
            )
            ->paginate(5);

        return view('livewire.indi-reports', [
            'riders'                       =>      $riders,
            'currentPage'                  =>      $riders->currentPage(),
            'totalPages'                   =>      $riders->lastPage(),
            'totalRecords'                 =>      $riders->total(),
            'noRecords'                    =>      $riders->isEmpty(),
        ]);
    }
}
