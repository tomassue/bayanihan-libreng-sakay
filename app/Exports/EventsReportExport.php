<?php

namespace App\Exports;

use App\Invoice;
use App\Models\TransactionModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class EventsReportExport implements FromView
{
    public $start_date;
    public $end_date;
    public $query_acc_type;
    public $query_event;

    public function __construct($start_date, $end_date, $query_acc_type, $query_event)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->query_acc_type = $query_acc_type;
        $this->query_event = $query_event;
    }


    public function view(): View
    {
        $query = TransactionModel::join('client_information', 'transactions.id_client', '=', 'client_information.id')
            ->join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
            ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
            ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
            ->select(
                DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                'events.event_name',
                DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS event_date"),
                'events.event_location AS event_location',
                'transactions.destination AS destination',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname")
            );

        if (!empty($this->query_acc_type)) {
            $query->where('client_information.user_type', 'like', '%' . $this->query_acc_type . '%');
        }

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('events.event_date', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->query_event)) {
            $query->where('events.id', $this->query_event);
        }

        $clients_transact = $query->get();

        return view('exports.events-report-export', [
            'clients_transact' => $clients_transact
        ]);
    }
}
