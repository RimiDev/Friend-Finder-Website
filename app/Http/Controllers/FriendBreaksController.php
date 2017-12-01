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
    /**
     * FriendBreaksController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('findFriendBreaks');
    }

    /**
     * Checks if all the fields from the user are valid inputs
     * @return bool
     */
    private function validateFields()
    {
        $valid = false;
        if ($_POST['submitSearchBreaks']) {
            if (isset($_POST['nameBreakSearch']) & isset($_POST['startTimeSearch']) & isset($_POST['endTimeSearch'])) {
                if (!isEmpty($_POST['nameBreakSearch']) & !isEmpty($_POST['startTimeSearch']) & !isEmpty($_POST['endTimeSearch'])) {
                    if (ctype_alpha($_POST['nameBreakSearch']) & is_numeric($_POST['startTimeSearch']) & is_numeric($_POST['endTimeSearch'])) {
                        if (($_POST['startTimeSearch'] > 0 & $_POST['startTimeSearch'] < 2400) &
                            ($_POST['endTimeSearch'] > $_POST['startTimeSearch'] & $_POST['endTimeSearch'] < 2400)) {
                            $valid = true;
                        } else {
                            $valid = false;
                        }
                    } else {
                        $valid = false;
                    }
                } else {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
        }
        return $valid;
    }
}
