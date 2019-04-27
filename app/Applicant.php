<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    public function account(){
        return $this->hasOne('\App\Account','id');
    }

    public function role(){
        return $this->hasOne('\App\Role','id');
    }
}
