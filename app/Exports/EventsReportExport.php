<?php

namespace App\Exports;

use App\Invoice;
use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use App\Models\TransactionModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class EventsReportExport implements FromView
{
    public $start_date;
    public $end_date;
    public $query_event;

    public function __construct($start_date, $end_date, $query_event)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->query_event = $query_event;
    }


    public function view(): View
    {
        $query = EventOrganizationsModel::join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
            ->select(
                'event_organizations.id AS id',
                'events.id AS events_id',
                'organization_information.id AS organization_information_id',
                'organization_information.organization_name',
                DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS event_date"),
                'events.event_name',
                'events.event_location AS event_location',
            );

        if (!empty($this->query_event)) {
            $query->where('events.id', $this->query_event);
        }

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('events.event_date', [$this->start_date, $this->end_date]);
        }

        $event_organization = $query->get();

        return view('exports.events-report-export', [
            'event_organization' => $event_organization
        ]);
    }
}
