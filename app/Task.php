<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    //belongsTo設定
    public function entry()
    {
        return $this->belongsTo('App\Entry');
    }

}
