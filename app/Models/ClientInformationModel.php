<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientInformationModel extends Model
{
    use HasFactory;

    protected $table = 'client_information';

    protected $fillable = [
        'user_id',
        'last_name',
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'birthday',
        'contact_number',
        'address',
        'id_school',
        'guardian_name',
        'guardian_contact_number',

    ];
}
