<?php

namespace App\Livewire;

use App\Exports\EventsReportExport;
use App\Models\ClientInformationModel;
use App\Models\TransactionModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Event Report')]

class EventsReport extends Component
{
    use WithPagination;

    // Searches
    public $start_date = "", $end_date = "", $query_acc_type = "";

    // PDF
    public $s_date = "";

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->start_date     = "";
        $this->end_date       = "";
        $this->query_acc_type = "";
    }

    public function render()
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
            )
            ->where('client_information.user_type', 'like', '%' . $this->query_acc_type . '%');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('events.event_date', [$this->start_date, $this->end_date]);
        }

        $clients_transact = $query->paginate(5);

        return view('livewire.events-report', [
            'clients_transact'       =>  $clients_transact,
            'currentPage'            =>  $clients_transact->currentPage(),
            'totalPages'             =>  $clients_transact->lastPage(),
            'totalRecords'           =>  $clients_transact->total(),
            'noRecords'              =>  $clients_transact->isEmpty(),
        ]);
    }

    public function printPDF($start_date = "", $end_date = "", $query_acc_type = "")
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

        if (!empty($query_acc_type)) {
            $query->where('client_information.user_type', 'like', '%' . $query_acc_type . '%');
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('events.event_date', [$start_date, $end_date]);
        }

        $clients_transact = $query->get();

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.events-report-pdf',
            [
                'clients_transact'  => $clients_transact,
                'start_date'        => $start_date,
                'end_date'          => $end_date,
                'account_type'      => $query_acc_type
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream();

        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'reports.pdf');
    }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;
        $query_acc_type = $this->query_acc_type;

        return Excel::download(new EventsReportExport($start_date, $end_date, $query_acc_type), 'eventsreport.xlsx');
    }
}
