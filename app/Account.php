<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Role;

class Account extends Authenticatable
{
    use SoftDeletes;
    protected $fillable = ['username','password','photo','facebook_username'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
