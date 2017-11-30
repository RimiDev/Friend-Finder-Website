<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'Courses';

    protected $fillable = ['classID', 'courseID' , 'sectionID', 'day', 'startTime', 'endTime'];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
