<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    public function student()
    {
        return $this->belongsTo('App\Student')->get()->all()[0];
    }

    public function course()
    {
        return $this->belongsTo('App\Course')->get()->all()[0];
    }
}
