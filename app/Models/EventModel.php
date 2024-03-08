<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventModel extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'event_date',
        'event_location',
        'google_map_link',
        'time_start',
        'time_end',
        'category',
        'estimated_number_of_participants',
        'status',
        'tag',
    ];

    public function scopeSearch($query, $value)
    {
        return $query->where('event_name', 'like', "%{$value}%");
    }
}
