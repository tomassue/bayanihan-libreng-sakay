<?php

namespace App\Exports;

use App\Models\OrganizationInformationModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class OrgReportsExport implements FromView
{
    public $start_date;
    public $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function view(): View
    {
        $query = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select(
                'organization_information.id AS org_id',
                'organization_name',
                DB::raw("DATE_FORMAT(date_established, '%b %d, %Y') AS date_established"),
                'address',
                'representative_name',
                'representative_position',
                'representative_contact_number',
                'users.contactNumber AS contact_number'
            )
            ->orderBy('organization_information.created_at', 'DESC');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('organization_information.created_at', [$this->start_date, $this->end_date]);
        }

        $organizations = $query->get();

        return view('exports.org-report-export', [
            'organizations' => $organizations
        ]);
    }
}
