<?php

namespace App\Livewire;

use App\Exports\ClientsReportExport;
use App\Models\ClientInformationModel;
use App\Models\EventModel;
use App\Models\TransactionModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Client Report')]

class ClientsReport extends Component
{
    use WithPagination;

    public $start_date = "", $end_date = "", $query_acc_type = "", $query_event = "";

    public function search()
    {
        $this->resetPage();
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

        // $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
        //     ->select(
        //         DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
        //         'users.contactNumber AS contactNumber',
        //         'client_information.user_type AS user_type',
        //         'client_information.created_at'
        //     );

        // if (!empty($this->start_date) && !empty($this->end_date)) {
        //     $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
        // }

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

        if (!empty($this->query_event)) {
            $query->where('events.id', $this->query_event);
        }

        $clients = $query->paginate(10);

        return view('livewire.clients-report', [
            'clients'       =>  $clients,
            'currentPage'   =>  $clients->currentPage(),
            'totalPages'    =>  $clients->lastPage(),
            'totalRecords'  =>  $clients->total(),
            'noRecords'     =>  $clients->isEmpty(),

            'event'         =>  $event
        ]);
    }

    public function clear()
    {
        $this->start_date     = "";
        $this->end_date       = "";
        $this->query_acc_type = "";
        $this->query_event    = "";
    }

    public function printPDF($start_date = "", $end_date = "", $query_acc_type = "", $query_event = "")
    {
        # Replace 'null' values with empty string
        $start_date = ($start_date === 'null') ? '' : Crypt::decrypt($start_date);
        $end_date = ($end_date === 'null') ? '' : Crypt::decrypt($end_date);
        $query_acc_type = ($query_acc_type === 'null') ? '' : Crypt::decrypt($query_acc_type);
        $query_event = ($query_event === 'null') ? '' : Crypt::decrypt($query_event);

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

        $clients = $query->get();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.clients-report-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'clients'           => $clients,
                'start_date'        => $start_date,
                'end_date'          => $end_date,
                'account_type'      => $query_acc_type,
                'query_event'       => !empty($event_detail) ? $event_detail : ""
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

    // public function printPDF()
    // {
    //     $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
    //         ->select(
    //             DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
    //             'users.contactNumber AS contactNumber',
    //             'client_information.user_type AS user_type',
    //             'client_information.created_at'
    //         );

    //     if (!empty($this->start_date) && !empty($this->end_date)) {
    //         $query->whereBetween('client_information.created_at', [$this->start_date, $this->end_date]);
    //     }

    //     $clients = $query->get();

    //     // Logos to base64
    //     $bls_logo = public_path('assets/img/copy2.png');
    //     $city_logo = public_path('assets/img/cdo-seal.png');
    //     $rise_logo = public_path('assets/img/rise.png');

    //     $bls_logo64 = base64_encode(file_get_contents($bls_logo));
    //     $city_logo64 = base64_encode(file_get_contents($city_logo));
    //     $rise_logo64 = base64_encode(file_get_contents($rise_logo));

    //     // Generate PDF with QR code
    //     $pdf = PDF::loadView(
    //         'pdf-reports.clients-report-pdf',
    //         [
    //             'bls_logo'          => $bls_logo64,
    //             'city_logo'         => $city_logo64,
    //             'rise_logo'         => $rise_logo64,
    //             'clients'           => $clients,
    //             'start_date'        => $this->start_date,
    //             'end_date'          => $this->end_date
    //         ]
    //     )
    //         ->setPaper('a4', 'portrait')
    //         ->setOption(['defaultFont' => 'roboto'])
    //         ->setOption('isRemoteEnabled', true);

    //     return response()->streamDownload(function () use ($pdf) {
    //         echo $pdf->stream();
    //     }, 'client-report.pdf');
    // }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;
        $query_acc_type = $this->query_acc_type;
        $query_event    = $this->query_event;

        return Excel::download(new ClientsReportExport($start_date, $end_date, $query_acc_type, $query_event), 'clientsreport.xlsx');
    }
}
