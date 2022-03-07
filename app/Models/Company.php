<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Licences;

class Company extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company';
    protected $primaryKey = 'company_id';

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id','name', 'greek_name', 'private_key','public_key','status'
    ];

    public function license(){
        return $this->hasOne(Licences::Class,'company_id');
    }

    
}
