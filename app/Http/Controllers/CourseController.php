<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;

class CourseController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getCourses(Request $request) {
        $session = $request->session();

        $couseArray = array();


    }
}
