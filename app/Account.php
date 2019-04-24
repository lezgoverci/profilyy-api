<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['username','password','profile_photo'];

    public function user(){
        return $this->belongsTo('\App\User','account_id','id');
    }
}
