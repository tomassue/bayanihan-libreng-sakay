<?php

namespace App\Livewire;

use App\Exports\IndiReportExport;
use App\Models\IndividualInformationModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Riders Reports')]
class IndiReports extends Component
{
    use WithPagination;

    // Filter
    public $search_rider;

    // indiReportModal
    public $indiID;

    public function render()
    {
        $auth_org_id = Auth::user()->organization_information->id;

        $riders = IndividualInformationModel::where('id_organization', $auth_org_id)
            ->select(
                'id',
                DB::raw("CONCAT(COALESCE(last_name, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
            )
            ->where('first_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('middle_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('last_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('ext_name', 'like', '%' . $this->search_rider . '%')
            ->paginate(10);

        // indiReportModal
        $riderTransactions = TransactionModel::join('event_organization_riders', 'transactions.id_event_organization_riders', '=', 'event_organization_riders.id')
            ->join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->join('client_information', 'transactions.id_client', '=', 'client_information.id')
            ->select(
                'events.event_name AS event',
                'events.event_date AS date',
                DB::raw("CONCAT(COALESCE(client_information.last_name, ''), ' ', COALESCE(client_information.first_name, ''), ' ', COALESCE(client_information.middle_name, ''), ' ', COALESCE(client_information.ext_name, '')) AS client_fullname")
            )
            ->where('event_organization_riders.id_individual', $this->indiID)
            ->get();

        return view('livewire.indi-reports', [
            'riders'                       =>      $riders,
            'currentPage'                  =>      $riders->currentPage(),
            'totalPages'                   =>      $riders->lastPage(),
            'totalRecords'                 =>      $riders->total(),
            'noRecords'                    =>      $riders->isEmpty(),

            'riderTransactions'            =>      $riderTransactions
        ]);
    }

    public function getindiID($id)
    {
        $this->indiID = $id;
    }

    public function printPDF()
    {
        $auth_org_id = Auth::user()->organization_information->id;

        $riders = IndividualInformationModel::where('id_organization', $auth_org_id)
            ->select(
                'id',
                DB::raw("CONCAT(COALESCE(last_name, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(ext_name, '')) AS rider_fullname"),
            )
            ->where('first_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('middle_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('last_name', 'like', '%' . $this->search_rider . '%')
            ->orWhere('ext_name', 'like', '%' . $this->search_rider . '%')
            ->paginate(10);

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.indi-report-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'riders'            => $riders
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'indi-report.pdf');
    }

    public function export()
    {
        $search_rider = $this->search_rider;

        return Excel::download(new IndiReportExport($search_rider), 'indireport.xlsx');
    }
}
