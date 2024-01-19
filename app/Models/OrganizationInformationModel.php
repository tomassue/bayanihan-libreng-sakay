<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];
}
