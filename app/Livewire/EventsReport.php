<?php

namespace App\Livewire;

use App\Exports\EventsReportExport;
use App\Models\ClientInformationModel;
use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use App\Models\TransactionModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Event Report')]

class EventsReport extends Component
{
    use WithPagination;

    // Searches
    public $start_date = "", $end_date = "", $query_event = "";

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
        $this->query_event    = "";
    }

    public function render()
    {
        // Event select field (Filter)
        $event = EventModel::select(
            'id',
            'event_name',
            DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS event_date"),
        )
            ->orderBy('event_date', 'DESC')
            ->get();

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

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('events.event_date', [$this->start_date, $this->end_date]);
        }

        if (!empty($this->query_event)) {
            $query->where('events.id', $this->query_event);
        }

        $event_organization = $query->paginate(10);

        return view('livewire.events-report', [
            'event_organization'        =>  $event_organization,
            'currentPage'               =>  $event_organization->currentPage(),
            'totalPages'                =>  $event_organization->lastPage(),
            'totalRecords'              =>  $event_organization->total(),
            'noRecords'                 =>  $event_organization->isEmpty(),

            'event'                     =>  $event
        ]);
    }

    # This old function is where we print PDF on stream() but there's an issue especially holding values.
    public function printPDF($start_date = "", $end_date = "", $query_event = "")
    {
        # Replace 'null' values with empty string
        $start_date = ($start_date === 'null') ? '' : Crypt::decrypt($start_date);
        $end_date = ($end_date === 'null') ? '' : Crypt::decrypt($end_date);
        $query_event = ($query_event === 'null') ? '' : Crypt::decrypt($query_event);

        // dd($start_date, $end_date, $query_event);

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

        if (!empty($query_event)) {
            $query->where('events.id', $query_event);

            $event_detail = EventModel::where('id', $query_event)
                ->select(
                    'event_name',
                    'event_date'
                )
                ->first();
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('events.event_date', [$start_date, $end_date]);
        }

        $event_organization = $query->get();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.events-report-pdf',
            [
                'bls_logo'              => $bls_logo64,
                'city_logo'             => $city_logo64,
                'rise_logo'             => $rise_logo64,
                'event_organization'    => $event_organization,
                'start_date'            => $start_date,
                'end_date'              => $end_date,
                'query_event'           => !empty($event_detail) ? $event_detail : ""
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

    # This method/function will automatically download the pdf
    // public function printPDF()
    // {
    //     $query = TransactionModel::join('client_information', 'transactions.id_client', '=', 'client_information.id')
    //         ->join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
    //         ->join('individual_information', 'event_organization_riders.id_individual', '=', 'individual_information.id')
    //         ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
    //         ->join('events', 'event_organizations.id_event', '=', 'events.id')
    //         ->join('organization_information', 'event_organizations.id_organization', '=', 'organization_information.id')
    //         ->select(
    //             DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
    //             'events.event_name',
    //             DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS event_date"),
    //             'events.event_location AS event_location',
    //             'transactions.destination AS destination',
    //             DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname")
    //         );

    //     if (!empty($this->query_acc_type)) {
    //         $query->where('client_information.user_type', 'like', '%' . $this->query_acc_type . '%');
    //     }

    //     if (!empty($this->start_date) && !empty($this->end_date)) {
    //         $query->whereBetween('events.event_date', [$this->start_date, $this->end_date]);
    //     }

    //     if (!empty($this->query_event)) {
    //         $query->where('events.id', $this->query_event);

    //         # Value to be displayed in the PDF
    //         $event_pdf = EventModel::where('id', $this->query_event)->first();
    //     }

    //     $clients_transact = $query->get();

    //     // Logos to base64
    //     $bls_logo = public_path('assets/img/copy2.png');
    //     $city_logo = public_path('assets/img/cdo-seal.png');
    //     $rise_logo = public_path('assets/img/rise.png');

    //     $bls_logo64 = base64_encode(file_get_contents($bls_logo));
    //     $city_logo64 = base64_encode(file_get_contents($city_logo));
    //     $rise_logo64 = base64_encode(file_get_contents($rise_logo));

    //     // Generate PDF with QR code
    //     $pdf = PDF::loadView(
    //         'pdf-reports.events-report-pdf',
    //         [
    //             'bls_logo'          => $bls_logo64,
    //             'city_logo'         => $city_logo64,
    //             'rise_logo'         => $rise_logo64,
    //             'clients_transact'  => $clients_transact,

    //             'start_date'        => $this->start_date,
    //             'end_date'          => $this->end_date,
    //             'account_type'      => $this->query_acc_type,
    //             'query_event'       => !empty($event_pdf->event_name)
    //         ]
    //     )
    //         ->setPaper('a4', 'portrait')
    //         ->setOption(['defaultFont' => 'roboto'])
    //         ->setOption('isRemoteEnabled', true);

    //     return response()->streamDownload(function () use ($pdf) {
    //         echo $pdf->stream();
    //     }, 'event-report.pdf');
    // }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;
        $query_event    = $this->query_event;

        return Excel::download(new EventsReportExport($start_date, $end_date, $query_event), 'eventsreport.xlsx');
    }
}
