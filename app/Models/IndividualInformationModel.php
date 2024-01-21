<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualInformationModel extends Model
{
    use HasFactory;

    protected $table = 'individual_information';

    protected $fillable = [
        'user_id',
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'contact_number',
        'address',
        'id_organization',
    ];
}