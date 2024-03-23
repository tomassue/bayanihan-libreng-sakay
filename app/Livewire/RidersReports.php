<?php

namespace App\Livewire;

use App\Exports\RidersReportsExport;
use App\Models\EventOrganizationRidersModel;
use App\Models\IndividualInformationModel;
use App\Models\OrganizationInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Rider Report')]

class RidersReports extends Component
{
    use WithPagination;

    // Search
    public $start_date = "", $end_date = "", $query_org = "";

    // Modal
    public $riderID;

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->query_org  = "";
        $this->start_date = "";
        $this->end_date   = "";
    }

    public function render()
    {
        $query = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
            ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
            ->select(
                'individual_information.id',
                'organization_information.organization_name AS organization',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
            )
            ->where('individual_information.id_organization', 'like', '%' . $this->query_org . '%');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('individual_information.created_at', [$this->start_date, $this->end_date]);
        }

        $riders = $query->paginate(10);

        // Select Field (Organization)
        $organizations = OrganizationInformationModel::select('id AS orgID', 'organization_name')
            ->get();

        // riders-reports-modal
        $eventsjoined = EventOrganizationRidersModel::join('event_organizations', 'event_organization_riders.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->where('event_organization_riders.id_individual', $this->riderID)
            ->select(
                'event_organization_riders.id AS id',
                'events.event_name AS event',
                'events.event_date AS date'
            )
            ->orderBy('events.created_at', 'DESC')
            ->get();

        return view('livewire.riders-reports', [
            'riders'        =>  $riders,
            'currentPage'   =>  $riders->currentPage(),
            'totalPages'    =>  $riders->lastPage(),
            'totalRecords'  =>  $riders->total(),
            'noRecords'     =>  $riders->isEmpty(),

            'organizations' =>  $organizations,

            'eventsjoined'  =>  $eventsjoined
        ]);
    }

    // public function printPDF($start_date = "", $end_date = "", $query_org = "")
    // {
    //     $query = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
    //         ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
    //         ->select(
    //             'individual_information.id',
    //             'organization_information.organization_name AS organization',
    //             DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
    //         )
    //         ->where('individual_information.id_organization', 'like', '%' . $query_org . '%');

    //     if (!empty($start_date) && !empty($end_date)) {
    //         $query->whereBetween('individual_information.created_at', [$start_date, $end_date]);
    //     }

    //     $riders = $query->get();

    //     // Logos to base64
    //     $bls_logo = public_path('assets/img/copy2.png');
    //     $city_logo = public_path('assets/img/cdo-seal.png');
    //     $rise_logo = public_path('assets/img/rise.png');

    //     $bls_logo64 = base64_encode(file_get_contents($bls_logo));
    //     $city_logo64 = base64_encode(file_get_contents($city_logo));
    //     $rise_logo64 = base64_encode(file_get_contents($rise_logo));

    //     // Generate PDF with QR code
    //     $pdf = PDF::loadView(
    //         'pdf-reports.riders-report-pdf',
    //         [
    //             'bls_logo'          => $bls_logo64,
    //             'city_logo'         => $city_logo64,
    //             'rise_logo'         => $rise_logo64,
    //             'riders'            => $riders,
    //             'start_date'        => $start_date,
    //             'end_date'          => $end_date,
    //             'query_org'         => $query_org
    //         ]
    //     )
    //         ->setPaper('a4', 'portrait')
    //         ->setOption(['defaultFont' => 'roboto'])
    //         ->setOption('isRemoteEnabled', true);

    //     return $pdf->stream();

    //     // return response()->streamDownload(function () use ($pdf) {
    //     //     echo $pdf->stream();
    //     // }, 'reports.pdf');
    // }

    public function printPDF()
    {
        $query = IndividualInformationModel::join('users', 'individual_information.user_id', '=', 'users.user_id')
            ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
            ->select(
                'individual_information.id',
                'organization_information.organization_name AS organization',
                DB::raw("CONCAT(COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
            )
            ->where('individual_information.id_organization', 'like', '%' . $this->query_org . '%');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('individual_information.created_at', [$this->start_date, $this->end_date]);
        }

        $riders = $query->get();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.riders-report-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'riders'            => $riders,
                'start_date'        => $this->start_date,
                'end_date'          => $this->end_date,
                'query_org'         => $this->query_org
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'riders-reports.pdf');
    }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;
        $query_org      = $this->query_org;

        return Excel::download(new RidersReportsExport($start_date, $end_date, $query_org), 'ridersreport.xlsx');
    }

    public function getriderID($id)
    {
        $this->riderID = $id;
    }
}
