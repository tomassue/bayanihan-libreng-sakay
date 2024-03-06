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
        'user_type',
        'last_name',
        'first_name',
        'middle_name',
        'ext_name',
        'sex',
        'birthday',
        'address',
        'id_school',
        'guardian_name',
        'guardian_contact_number',
    ];

    public function scopeSearch($query, $value)
    {
        return $query->where('last_name', 'like', "%{$value}%")
            ->orWhere('first_name', 'like', "%{$value}%")
            ->orWhere('middle_name', 'like', "%{$value}%")
            ->orWhere('ext_name', 'like', "%{$value}%");
    }
}
