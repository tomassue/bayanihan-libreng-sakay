<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrganizationsModel extends Model
{
    use HasFactory;

    protected $table = 'event_organizations';

    protected $fillable = [
        'id_event',
        'id_organization',
    ];
}
