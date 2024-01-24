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
        'contact_number',
        'status',
    ];

    // Join user table
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
