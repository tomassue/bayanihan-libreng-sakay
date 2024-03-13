<?php

namespace App\Exports;

use App\Models\ClientInformationModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ClientsReportExport implements FromView
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
        $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select(
                DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                'users.contactNumber AS contactNumber',
                'client_information.user_type AS user_type',
                'client_information.created_at'
            );

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
        }

        $clients = $query->get();

        return view('exports.clients-report-export', [
            'clients' => $clients
        ]);
    }
}
