<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clients extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','company_id','name','region','address','city','postal_code','telephone','mobile','tax_number','tax_post','occupation',
        'email','discount','payment_mode','total_sales_amount','total_payment_amount','sub_total_amount','note','note2','latitude','longitude'	
    ];

   
}
