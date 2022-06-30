<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Invoices extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id','client_id','device_id','company_id','type','invoice_number','payment_method','address','maintainance',
        'note','user_info','status','sub_total','final_total', 'discount', 'vat', 'credit_amount'
    ];
}
