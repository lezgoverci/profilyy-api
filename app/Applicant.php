<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;
    public function account(){
        return $this->hasOne('\App\Account','id');
    }

    public function role(){
        return $this->hasOne('\App\Role','id');
    }
}
