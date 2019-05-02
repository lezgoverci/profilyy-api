<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Role;

class Account extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'fname','lname','address','phone', 'gender',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
