<?php

namespace App\Exports;

use App\Models\EventAttendanceModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceReportExport implements FromView
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function view(): View
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
            ->where('individual_information.id_organization', [Auth::user()->organization_information->id])
            ->where('event_organizations.id_event', 'LIKE', '%' . $this->query . '%')
            ->paginate(10);

        return view('exports.attendance-report-export', [
            'attendance' => $attendance
        ]);
    }
}
