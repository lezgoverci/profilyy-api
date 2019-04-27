<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Role;

class Account extends Model
{
    use SoftDeletes;
    protected $fillable = ['username','password','photo','facebook_username'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
