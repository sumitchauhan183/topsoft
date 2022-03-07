<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Company;

class Licences extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'licences';

    public $timestamps = true;
    protected $primaryKey = 'licence_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'licence_id','company_id','licence_key','device_count','expiration_date'
    ];	

    public function company(){
        return $this->belongsTo(Company::Class);
    }
}
