<?php

namespace App\Exports;

use App\Models\IndividualInformationModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IndiReportExport implements FromView
{
    public $search_rider;

    public function __construct($search_rider)
    {
        $this->search_rider = $search_rider;
    }

    public function view(): View
    {
        $auth_org_id = Auth::user()->organization_information->id;

        $riders = IndividualInformationModel::where('id_organization', $auth_org_id)
            ->select(
                'id',
                DB::raw("CONCAT(COALESCE(last_name, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
            )
            ->where('first_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('middle_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('last_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('ext_name', 'like', '%' . $this->search_rider . '%')
            ->paginate(10);

        return view('exports.indi-report-export', [
            'riders' => $riders
        ]);
    }
}
