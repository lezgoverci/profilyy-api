<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use SoftDeletes;
    protected $fillable = ['applicant_id','file'];

    public function applicant(){
        return $this->hasOne('\App\Applicant','id', 'applicant_id');
    }
}
