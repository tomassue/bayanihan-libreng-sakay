<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrganizationRidersModel extends Model
{
    use HasFactory;

    protected $table = 'event_organization_riders';

    protected $fillable = [
        'id_event_organization',
        'id_individual',
    ];
}
