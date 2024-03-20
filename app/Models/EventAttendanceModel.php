<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendanceModel extends Model
{
    use HasFactory;

    protected $table = "event_attendance";

    protected $fillable = [
        'id_event_organization',
        'id_individual'
    ];
}
