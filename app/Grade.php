<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Student')->get()[0];
    }

    public function course()
    {
        return $this->belongsTo('App\Course')->get()[0];
    }
}
