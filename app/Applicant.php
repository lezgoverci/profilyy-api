<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    public function account(){
        return $this->hasOne('\App\Account','id');
    }
}
