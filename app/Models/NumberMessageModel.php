<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberMessageModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_number_messages';

    protected $fillable = [
        'user_id',
        'phone_number',
        'otp_code',
        'is_verified',
        'otp_type',
        'sms_status',
        'sms_trans_id',
    ];
}
