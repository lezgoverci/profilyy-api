<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;

class Account extends Model
{
    protected $fillable = ['username','password','photo','facebook_username'];

    public function user(){
        return $this->belongsTo('App\User','account_id','id');
    }

    public function role(){
        return $this->hasOne('App\Role', 'id','role_id');
    }
}
