<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Course;
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
     * Finds the users friend that have overlapping breaks
     */
    public function findBreakFriends(Request $request)
    {
        $startBreak = $request->get('startName');
        $endBreak = $request->get('endName');

        // Gets each friend once
        $friendStatus = Friend::where('email','=', Auth::user()->email)->get();
        foreach ($friendStatus as $friend)
            $friendObjs[] = User::where('email', '=', $friend->friendEmail)->orderby('email')->first();

        for ($i = 0; $i < count($friendObjs); $i++)
        {
            $friendCourse = Course::where('day', '=', $this->getDay($request))->
            whereIn('id', function ($q) use ($friendObjs, $i)
            {
                $q->select('course_id')->from('user_course')->
                where('email', '=', $friendObjs[$i]->email)->orderby('email');
            }
            )->orderby('startTime')->get();
        }

        //Get friend breaks
        if (count($friendCourse) > 1)
        {
            for ($i = 0; $i < count($friendCourse) - 1; $i++)
            {
                if(count($friendCourse) == 3)
                    $i++;
                if(count($friendCourse) == 4)
                    $i = $i + 2;
                if($friendCourse[$i]->endTime < $startBreak && $friendCourse[++$i]->startTime > $endBreak)
                {
                    $i = $i - 1;
                    $endFirstFriend = $friendCourse[$i]->endTime;
                    if (++$i < count($friendCourse))
                    {
                        $startSecondFriend = $friendCourse[$i]->startTime;
                        $i = $i - 1;
                    }
                    $breaksFriend[] = $endFirstFriend;
                    $breaksFriend[] = $startSecondFriend;
                }
            }
        }

        // Check if friends have break
        if(isset($breaksFriend) && count($breaksFriend) > 0)
            return view('findFriendBreaks', ["friendNames" => $friendObjs, "breaksFriend" => $breaksFriend]);
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
    private function getDay(Request $request)
    {
        $value = 0;
        $day = $request->get('dayName');
        if (isset($day) && ctype_alpha($day)) {
            $day = trim(strtolower($day));
            switch ($day) {
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
        return $value;
    }
}
