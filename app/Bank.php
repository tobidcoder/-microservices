<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $fillable = [
        'account_number',
        'bank',
        'bvn',
        'user_id',
    ];
}
