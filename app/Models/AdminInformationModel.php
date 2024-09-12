<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInformationModel extends Model
{
    use HasFactory;

    protected $table = "admin_information";

    protected $fillable = [
        'user_id',
        'name'
    ];
}
