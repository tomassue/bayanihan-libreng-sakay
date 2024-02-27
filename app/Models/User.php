<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'contactNumber',
        'id_account_type',
        'password',
        'status',
        'remarks',
        'tag',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Define the relationship
    /**
     * In Laravel, when you define a belongsTo relationship, Laravel assumes that the foreign key is the primary key of the related model unless you specify it explicitly. If the foreign key is not the primary key, you need to inform Laravel about it.
     * 
     * Alternatively, you can specify the foreign key in the belongsTo relationship method. 
     * 
     * Below, the second argument is the foreign key on the current model, and the third argument is the related key on the related model (OrganizationInformationModel).
     * 
     * Then you can use this to call any data based on the other table's column, Auth::user()->organization_information->column_name.
     */
    public function organization_information()
    {
        return $this->belongsTo(OrganizationInformationModel::class, 'user_id', 'user_id');
    }
}
