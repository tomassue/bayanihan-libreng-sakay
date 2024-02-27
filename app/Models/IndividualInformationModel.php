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
        'address',
        'id_organization',
    ];

    public function scopeSearch($query, $value)
    {
        return $query->where('last_name', 'like', "%{$value}%")
            ->orWhere('first_name', 'like', "%{$value}%")
            ->orWhere('middle_name', 'like', "%{$value}%");
    }
}
