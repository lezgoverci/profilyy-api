<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;
    protected $fillable = ['account_id','role_id'];

    public function account(){
        return $this->belongsTo('\App\Account','id','account_id');
    }

    public function role(){
        return $this->hasOne('\App\Role','id','role_id');
    }
}
