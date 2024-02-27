<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class OrganizationInformationModel extends Model
{
    use HasFactory;

    protected $table = 'organization_information';

    protected $fillable = [
        'user_id',
        'organization_name',
        'date_established',
        'address',
        'status',
    ];

    // Join user table
    public function users()
    {
        // return $this->belongsTo(User::class);
        // return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    //search
    public function scopeSearch($query, $value)
    {
        return $query->where('organization_name', 'like', "%{$value}%");
    }
}
