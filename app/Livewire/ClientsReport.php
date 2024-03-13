<?php

namespace App\Livewire;

use App\Exports\ClientsReportExport;
use App\Models\ClientInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Client Report')]

class ClientsReport extends Component
{
    use WithPagination;

    public $start_date = "", $end_date = "";

    public function search()
    {
        $this->resetPage();
    }

    public function render()
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

        $clients = $query->paginate(5);

        return view('livewire.clients-report', [
            'clients'       =>  $clients,
            'currentPage'   =>  $clients->currentPage(),
            'totalPages'    =>  $clients->lastPage(),
            'totalRecords'  =>  $clients->total(),
            'noRecords'     =>  $clients->isEmpty(),
        ]);
    }

    public function clear()
    {
        $this->start_date = "";
        $this->end_date = "";
    }

    public function printPDF($start_date = "", $end_date = "")
    {
        $query = ClientInformationModel::join('users', 'client_information.user_id', '=', 'users.user_id')
            ->select(
                DB::raw("CONCAT(COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname"),
                'users.contactNumber AS contactNumber',
                'client_information.user_type AS user_type',
                'client_information.created_at'
            );

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('client_information.created_at', [$start_date, $end_date]);
        }

        $clients = $query->get();

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.clients-report-pdf',
            [
                'clients'           => $clients,
                'start_date'        => $start_date,
                'end_date'          => $end_date
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream();
    }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;

        return Excel::download(new ClientsReportExport($start_date, $end_date), 'clientsreport.xlsx');
    }
}
