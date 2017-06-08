<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
    protected $table = 'currencies';

    public function transactions()
    {
        return $this->hasMany('App\Transaction', 'currency_id');
    }
}
