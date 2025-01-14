<?php

namespace App\Livewire;

use App\Exports\OrgReportsExport;
use App\Models\OrganizationInformationModel;
use Livewire\Component;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Organization Report')]

class OrgReports extends Component
{
    use WithPagination;

    // Search
    public $start_date = "", $end_date = "";

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->start_date = "";
        $this->end_date   = "";
    }

    public function render()
    {
        $query = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select(
                'organization_information.id AS org_id',
                'organization_name',
                DB::raw("DATE_FORMAT(date_established, '%b %d, %Y') AS date_established"),
                'address',
                'representative_name',
                'representative_position',
                'representative_contact_number',
                'users.contactNumber AS contact_number'
            )
            ->orderBy('organization_information.created_at', 'DESC');

        if (!empty($this->start_date) && !empty($this->end_date)) {
            $query->whereBetween('organization_information.created_at', [$this->start_date, $this->end_date]);
        }

        $organizations = $query->paginate(10);

        return view('livewire.org-reports', [
            'organizations'     =>  $organizations,
            'currentPage'       =>  $organizations->currentPage(),
            'totalPages'        =>  $organizations->lastPage(),
            'totalRecords'      =>  $organizations->total(),
            'noRecords'         =>  $organizations->isEmpty(),
        ]);
    }

    public function printPDF($start_date = "", $end_date = "")
    {
        $query = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
            ->select(
                'organization_information.id AS org_id',
                'organization_name',
                DB::raw("DATE_FORMAT(date_established, '%b %d, %Y') AS date_established"),
                'address',
                'representative_name',
                'representative_position',
                'representative_contact_number',
                'users.contactNumber AS contact_number'
            )
            ->orderBy('organization_information.created_at', 'DESC');

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('organization_information.created_at', [$start_date, $end_date]);
        }

        $organizations = $query->get();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.org-report-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'organizations'     => $organizations,
                'start_date'        => $start_date,
                'end_date'          => $end_date,
            ]
        )
            ->setPaper('a4', 'landscape')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream();

        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'reports.pdf');
    }

    // public function printPDF()
    // {
    //     $query = OrganizationInformationModel::join('users', 'organization_information.user_id', '=', 'users.user_id')
    //         ->select(
    //             'organization_information.id AS org_id',
    //             'organization_name',
    //             DB::raw("DATE_FORMAT(date_established, '%b %d, %Y') AS date_established"),
    //             'address',
    //             'representative_name',
    //             'representative_position',
    //             'representative_contact_number',
    //             'users.contactNumber AS contact_number'
    //         )
    //         ->orderBy('organization_information.created_at', 'DESC');

    //     if (!empty($this->start_date) && !empty($this->end_date)) {
    //         $query->whereBetween('organization_information.created_at', [$this->start_date, $this->end_date]);
    //     }

    //     $organizations = $query->get();

    //     // Logos to base64
    //     $bls_logo = public_path('assets/img/copy2.png');
    //     $city_logo = public_path('assets/img/cdo-seal.png');
    //     $rise_logo = public_path('assets/img/rise.png');

    //     $bls_logo64 = base64_encode(file_get_contents($bls_logo));
    //     $city_logo64 = base64_encode(file_get_contents($city_logo));
    //     $rise_logo64 = base64_encode(file_get_contents($rise_logo));

    //     // Generate PDF with QR code
    //     $pdf = PDF::loadView(
    //         'pdf-reports.org-report-pdf',
    //         [
    //             'bls_logo'          => $bls_logo64,
    //             'city_logo'         => $city_logo64,
    //             'rise_logo'         => $rise_logo64,
    //             'organizations'     => $organizations,
    //             'start_date'        => $this->start_date,
    //             'end_date'          => $this->end_date,
    //         ]
    //     )
    //         ->setPaper('a4', 'landscape')
    //         ->setOption(['defaultFont' => 'roboto'])
    //         ->setOption('isRemoteEnabled', true);

    //     return response()->streamDownload(function () use ($pdf) {
    //         echo $pdf->stream();
    //     }, 'organization-reports.pdf');
    // }

    public function export()
    {
        $start_date     = $this->start_date;
        $end_date       = $this->end_date;

        return Excel::download(new OrgReportsExport($start_date, $end_date), 'orgreport.xlsx');
    }
}
