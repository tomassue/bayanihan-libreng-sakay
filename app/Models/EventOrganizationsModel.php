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

    public function events()
    {
        return $this->belongsTo(EventModel::class, 'id', 'id_event');
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('id_event', 'like', "%{$value}");
    }
}
