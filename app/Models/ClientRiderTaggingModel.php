<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRiderTaggingModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "client_rider_tagging";

    protected $fillable = [
        'id_event',
        'id_client',
        'id_individual',
        'is_message_sent'
    ];
}
