<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['courseID'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
