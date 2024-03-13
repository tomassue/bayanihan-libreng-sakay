<?php

namespace App\Exports;

use App\Models\IndividualInformationModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class RidersReportsExport implements FromView
{
    public $start_date;
    public $end_date;
    public $query_org;

    public function __construct($start_date, $end_date, $query_org)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->query_org = $query_org;
    }
    public function view(): View
    {
        $query = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
            ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
            ->select(
                'individual_information.id',
                'organization_information.organization_name AS organization',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
            )
            ->where('individual_information.id_organization', 'like', '%' . $this->query_org . '%');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('individual_information.created_at', [$this->start_date, $this->end_date]);
        }

        $riders = $query->get();

        return view('exports.riders-report-export', [
            'riders' => $riders
        ]);
    }
}
