<?php

namespace App\Livewire;

use App\Exports\AttendanceReportExport;
use App\Models\EventAttendanceModel;
use App\Models\EventModel;
use App\Models\EventOrganizationsModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.page')]
#[Title('Attendance Report')]

class AttendanceReport extends Component
{
    use WithPagination;

    // Filter
    public $query;

    public function search()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->query  = "";
    }

    public function render()
    {
        $attendance = EventAttendanceModel::join('individual_information', 'event_attendance.id_individual', '=', 'individual_information.id')
            ->join('event_organizations', 'event_attendance.id_event_organization', '=', 'event_organizations.id')
            ->join('organization_information', 'individual_information.id_organization', '=', 'organization_information.id')
            ->select(
                'event_attendance.id AS event_id',
                'event_attendance.id_event_organization as event_org',
                DB::raw("CONCAT(COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
            )
            ->where('individual_information.id_organization', [Auth::user()->organization_information->id])
            ->where('event_organizations.id_event', 'LIKE', '%' . $this->query . '%')
            ->paginate(10);

        // Filter
        $events = EventOrganizationsModel::join('events', 'event_organizations.id_event', '=', 'events.id')
            ->select(
                'events.id',
                'events.event_name',
                'events.event_location',
                DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS events_date"),
                DB::raw("CONCAT(TIME_FORMAT(events.time_start, '%h:%i %p'), ' - ', TIME_FORMAT(events.time_end, '%h:%i %p')) AS events_time"),
            )
            ->orderBy('events.event_date', 'DESC')
            ->get();

        return view('livewire.attendance-report', [
            'attendance'    =>  $attendance,
            'currentPage'   =>  $attendance->currentPage(),
            'totalPages'    =>  $attendance->lastPage(),
            'totalRecords'  =>  $attendance->total(),
            'noRecords'     =>  $attendance->isEmpty(),

            'events'        =>  $events
        ]);
    }

    public function printPDF($query = "")
    {
        $attendance = EventAttendanceModel::join('individual_information', 'event_attendance.id_individual', '=', 'individual_information.id')
            ->join('event_organizations', 'event_attendance.id_event_organization', '=', 'event_organizations.id')
            ->join('events', 'event_organizations.id_event', '=', 'events.id')
            ->select(
                'event_attendance.id AS event_id',
                'event_attendance.id_event_organization as event_org',
                DB::raw("CONCAT(COALESCE(individual_information.last_name, ''), ' ', COALESCE(individual_information.first_name, ''), ' ', COALESCE(individual_information.middle_name, ''), ' ', COALESCE(individual_information.ext_name, '')) AS rider_fullname"),
                'events.event_name',
                DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS events_date"),
                DB::raw("CONCAT(TIME_FORMAT(events.time_start, '%h:%i %p'), ' - ', TIME_FORMAT(events.time_end, '%h:%i %p')) AS events_time"),
                'events.event_location AS location',
            )
            ->where('event_organizations.id_event', 'LIKE', '%' . decrypt($query) . '%')
            ->where('individual_information.id_organization', [Auth::user()->organization_information->id])
            ->paginate(10);

        // Filter
        $event = EventModel::where('id', decrypt($query))
            ->select(
                'event_name',
                DB::raw("DATE_FORMAT(events.event_date, '%b %d, %Y') AS events_date"),
                DB::raw("CONCAT(TIME_FORMAT(events.time_start, '%h:%i %p'), ' - ', TIME_FORMAT(events.time_end, '%h:%i %p')) AS events_time"),
                'event_location'
            )
            ->first();

        // Logos to base64
        $bls_logo = public_path('assets/img/copy2.png');
        $city_logo = public_path('assets/img/cdo-seal.png');
        $rise_logo = public_path('assets/img/rise.png');

        $bls_logo64 = base64_encode(file_get_contents($bls_logo));
        $city_logo64 = base64_encode(file_get_contents($city_logo));
        $rise_logo64 = base64_encode(file_get_contents($rise_logo));

        // Generate PDF with QR code
        $pdf = PDF::loadView(
            'pdf-reports.attendance-report-pdf',
            [
                'bls_logo'          => $bls_logo64,
                'city_logo'         => $city_logo64,
                'rise_logo'         => $rise_logo64,
                'attendance'        => $attendance,

                'org'               => Auth::user()->organization_information->organization_name,
                'event'             => $event
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption(['defaultFont' => 'roboto'])
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream();
    }

    public function export()
    {
        $query = $this->query;

        return Excel::download(new AttendanceReportExport($query), 'attendance-report.xlsx');
    }
}
