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
        'status',
        'remarks',
    ];

    public function events()
    {
        return $this->belongsTo(EventModel::class, 'id', 'id_event');
    }

    public function scopeSearch($query, $value)
    {
        // I directly called the `event_name` from events table since I made a join in the events() method.
        return $query->where('event_name', 'like', "%{$value}%");
    }
}
