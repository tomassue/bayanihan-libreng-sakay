<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'id_event_organization_riders',
        'id_client',
        'destination',
    ];
}
