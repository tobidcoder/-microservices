<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{

    protected $fillable =[
        'sector',
        'employer',
        'employer_address',
        'office_email',
        'office_phone',
    ];

    //Get employer staff (user)
    public function users(){
        return $this->hasMany('App\User');
}
}