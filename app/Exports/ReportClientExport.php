<?php

namespace App\Exports;

use App\Invoice;
use App\Models\ClientInformationModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportClientExport implements FromView
{
    public $start_date, $end_date, $search_client;

    public function __construct($start_date, $end_date, $search_client)
    {
        $this->start_date = $start_date;
        $this->end_date   = $end_date;
        $this->search_client = $search_client;
    }
    public function view(): View
    {
        $query = ClientInformationModel::search($this->search_client)
            ->join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select('users.id AS user_id', 'users.contactNumber AS contact_number', 'client_information.*')
            ->orderBy('created_at', 'DESC');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
        }

        $clients = $query->get();

        return view('exports.report-client-export', [
            'clients'   =>  $clients
        ]);
    }
}
