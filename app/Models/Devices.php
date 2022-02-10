<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Devices extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id','company_id','email','password','otp','unique_token','device_token','login_token', 'type','status'
    ];

    
}
