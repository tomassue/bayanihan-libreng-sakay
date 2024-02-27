<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSenderModel extends Model
{
    protected $connection = 'mysql2';

    use HasFactory;

    // Table in the server. No need to create this table in our local database.
    protected $table = 'tbl_sms_for_sending';

    public $timestamps = false;

    protected $fillable = [
        'trans_id',
        'received_id',
        'recipient',
        'recipient_message',
        'send_date',
    ];
}
