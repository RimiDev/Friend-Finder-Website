<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Course;
use App\User_course;
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
     * Returns the courses the user has
     * @return mixed
     */
    /*public function getUserCourses() {
        $courseInfo[] = null;
        // Get the user courses
        $userCourse[] = User_course::where('email', '=', Auth::user()->email)->get();

        foreach($userCourse as $course) {
            $arrayCourseId[] = $course->courseId;
        }
        for ($i = 0; $i < count($arrayCourseId); $i++) {
            $userCourseInfo[] = Course::where('courseID', '=', $arrayCourseId[$i])->get();
        }

        return $userCourseInfo;
    }*/

    /**
     * Gets the users friends email
     */
    public function getUserFriends() {

        // Gets each friend once
        $friendStatus = Friend::where('email','=', Auth::user()->email)->get();
        foreach ($friendStatus as $friend)
            $friendObjs[] = User::where('email', '=', $friend->friendEmail)->first();

        $arrayEmail[] = null;

        // Get the email of each friend and put it into an array
        foreach($friendObjs as $user) {
            $arrayEmail[] = $user->email;
        }

        // Return the array of email of the friends
        return $arrayEmail;
    }

    /**
     * Gets the users friends courses
     */
    public function getFriendBreaks($arrayFriendsEmail) {
        // Array of User_course objects
        $arrayFriendCourses[] = null;
        // Array of course ID
        $arrayCourseId[] = null;
        // Array of Course objects
        $arrayCourses[] = null;

        // Get user course for a specific day
        /*$courseForDay[] = User_course::where('email', '=', Auth::user()->email)->
            where('courseID', function ($q) { $q->select('id')->from('courses')->
            where('day', '=', $this->getDay()); })->get();*/

        $courseForDay[] = Course::where('day', '=', $this->getDay()->
            where('id', '=', function ($q) { $q->select('courseID')->from('user_course')->
            where('email', '=', Auth::user()->email);}))->get();

        // Arrays
        $breakArray[] = null;
        $breakFriendsArray[] = null;
        $friendsArray[] = null;

        // Get breaks
        if (count($courseForDay) > 1) {
            for ($i = 0; $i < count($courseForDay); $i++) {
                $endFirst = $courseForDay[$i]->endtime;
                if ($i++ < count($courseForDay)) {
                    $startSecond = $courseForDay[$i++]->starttime;
                    $i = $i - 2;
                }
                $breakArray[] = $endFirst;
                $breakArray[] = $startSecond;
            }
        }

        for ($i = 0; $i < count($arrayFriendsEmail); $i++) {
            $friendCourse = Course::where('day', '=', $this->getDay()->
                where('id', '=', function ($q, $arrayFriendsEmail, $i) { $q->select('courseID')->from('user_course')->
                where('email', '=', $arrayFriendsEmail[$i]);}))->get();
        }



        // Fetch courses the users friends have
        /*for ($i = 0; $i < count($arrayFriendsEmail); $i++) {
            $arrayFriendCourses[] = User_course::where('email', '=', $arrayFriendsEmail[$i])->
                where('courseID', function ($q) { $q->select('id')->from('courses')->
                where('day', '=', $this->getDay());})->get();
        }*/

        // Get friend breaks
        

        // Get the class ID of each course
        foreach($arrayFriendCourses as $course) {
            $arrayCourseId[] = $course->courseId;
        }

        // Fetch the course information
        for ($i = 0; $i < count($arrayCourseId); $i++) {
            $arrayCourses[] = Course::where('courseID', '=', $arrayCourseId[$i])->get();
        }

        // Will return multiple courses (sections)
        return $arrayCourses;
    }

    /**
     * Fetches the friends request from the user input
     * @param Request $request
     */
    public function friends(Request $request) {
        if ($request->get('submitSearchBreaks')) {
            if ($this->validateFields()) {
                // Converts the string into an int
                $day = $this->getDay();
            }
        }
    }

    /**
     * Checks if all the fields from the user are valid inputs
     * @return bool
     */
    private function validateFields()
    {
        $valid = false;
        if ($_POST['submitSearchBreaks']) {
            if (isset($_POST['dayBreakSearch']) & isset($_POST['startTimeSearch']) & isset($_POST['endTimeSearch'])) {
                if (!isEmpty($_POST['dayBreakSearch']) & !isEmpty($_POST['startTimeSearch']) & !isEmpty($_POST['endTimeSearch'])) {
                    if (ctype_alpha($_POST['dayBreakSearch']) & is_numeric($_POST['startTimeSearch']) & is_numeric($_POST['endTimeSearch'])) {
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

    /**
     * Gets the day from the user and puts it as an integer
     */
    private function getDay() {
        $value = 0;
        if ($_POST['submitSearchBreaks']) {
            if (isset($_POST['dayBreakSearch'])) {
                if (!isEmpty($_POST['dayBreakSearch'])) {
                    if (ctype_alpha($_POST['dayBreakSearch'])) {
                        $day = trim(strtolower($_POST['dayBreakSearch']));
                        switch($day) {
                            case "monday":
                                $value = 1;
                                break;
                            case "tuesday":
                                $value = 2;
                                break;
                            case "wednesday":
                                $value = 3;
                                break;
                            case "thursday":
                                $value = 4;
                                break;
                            case "friday":
                                $value = 5;
                                break;
                            default:
                                $value = 0;
                                break;
                        }
                    }
                }
            }
        }
        return $value;
    }
}
