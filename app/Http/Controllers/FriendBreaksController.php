<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Course;
use App\User_course;
use App\Course_teacher;
use App\Classes;
use Auth;

class FriendBreaksController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('findFriendBreaks');
    }
}
