<?php

namespace App\Http\Controllers;

use App\Classes;
use App\User_course;
use Illuminate\Http\Request;
use App\Course;
use App\Friend;
use App\User;
use Auth;

class ApiController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allfriends(Request $request)
    {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();

            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            $data = array();
            if (isset($friendNames) && count($friendNames) > 0) {
                foreach ($friendNames as $friends) {
                    $data += ['email' => $friends->email, 'name' => $friends->name];
                }
            }

            if (count($data) == 0) {
                return response()->json(['email' => 'No friend found', 'name' => 'No friend found']);
            }

            return response()->json($data, 401);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function coursefriends(Request $request)
    {
        // TODO : FINISH THIS
        // check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        $coursename = $request->get('coursename');
        $section = $request->get('section');

        // Getting the friend object
        $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();

        // Getting the user object of the friend
        foreach ($friendStatus as $friend)
            $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

        // Array of email
        $friendEmails = array();
        foreach ($friendNames as $f) {
            $friendEmails[] = $f->email;
        }

        // Array of courses
        $friendCourses = array();
        for ($i = 0; $i < count($friendEmails); $i++) {
            $friendCourses = User_course::where('email', '=', $friendEmails[$i])->first();
        }

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            $data = array();
            if (isset($friendCourses) && count($friendCourses) > 0) {
                foreach ($friendCourses as $c) {
                    $data += ['courseid' => $c];
                }
            }

            return response()->json($data, 401);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function friendbreaks(Request $request)
    {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        // Gets each friend once
        $friendStatus = Friend::where('email', '=', Auth::user()->email)->get();
        foreach ($friendStatus as $friend)
            $friendObjs[] = User::where('email', '=', $friend->friendEmail)->orderby('email')->first();

        $day = $request->get('day');
        $start = $request->get('starttime');
        $end = $request->get('endtime');

        // Arrays
        $name = array();
        $email = array();

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            $breaksFriend = 0;
            $j = 0;

            for ($i = 0; $i < count($friendObjs); $i++) {
                $friendCourse = Course::where('day', '=', $this->getDay($day))->
                whereIn('id', function ($q) use ($friendObjs, $i) {
                    $q->select('course_id')->from('user_course')->
                    where('email', '=', $friendObjs[$i]->email)->orderby('email');
                }
                )->orderby('startTime')->get();

                for ($course = 0; $course < count($friendCourse) - 1; $course++) {
                    $j++;
                    if ($friendCourse[$course]->endTime <= $start && $friendCourse[$j]->startTime >= $end) {
                        $email[] = $friendObjs[$i]->email;
                        $name[] = $friendObjs[$i]->name;
                        $breaksFriend++;
                    } else if ($friendCourse[$course]->endTime > $start && $friendCourse[$course]->endTime < $end) {
                        $email[] = $friendObjs[$i]->email;
                        $name[] = $friendObjs[$i]->name;
                        $breaksFriend++;
                    } else if ($friendCourse[$j]->startTime < $end && $friendCourse[$j]->startTime > $start) {
                        $email[] = $friendObjs[$i]->email;
                        $name[] = $friendObjs[$i]->name;
                        $breaksFriend++;
                    }
                } // End inner for loop
                $j = 0;

            } // End for loop
            $data = array();
            if (isset($friendObjs) && count($friendObjs) > 0) {
                for ($k = 0; $k < count($name); $k++) {
                    $data += ['email' => $email[$k], 'name' => $name[$k]];
                }
            }

            if (count($data) == 0) {
                return response()->json(['email' => 'No friend found', 'name' => 'No friend found']);
            }

            return response()->json($data, 401);

        } // End else
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function whereisfriend(Request $request)
    {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        $friendemail = $request->get('friendemail');
        $day = $request->get('day');
        $time = $request->get('time');

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            // Get friend courses
            $friendCourse = Course::where('day', '=', $this->getDay($day))->
            whereIn('id', function ($q) use ($friendemail) {
                $q->select('course_id')->from('user_course')->
                where('email', '=', $friendemail);}
            )->orderby('startTime')->get();

            // Get the class number
            foreach ($friendCourse as $c)
            {
                $class[] = Classes::where('classID', '=', $c->classID)->first();
            }

            foreach ($class as $classname)
            {
                $arrayclasses[] = $classname->classNumber;
            }

            if (isset($friendCourse) && count($friendCourse) > 0) {
                for ($i = 0; $i < count($friendCourse); $i++) {
                    if ($friendCourse[$i]->startTime < $time && $friendCourse[$i]->endTime > $time) {
                        $course[] = $arrayclasses[$i];
                        $section[] = $friendCourse[$i]->sectionID;
                        $starttime[] = $friendCourse[$i]->startTime;
                    }
                }
            }
        } // End if

        $data = array();
        if (isset($course) && count($course) > 0) {
            for ($k = 0; $k < count($course); $k++) {
                $data[] = ['course' => $course[$k], 'section' => $section[$k]];
            }
        }

        if (count($data) == 0) {
            return response()->json(['course' => '', 'section' => '']);
        }

        return response()->json($data, 401);
    }


    /**
     * Gets the day from the user and puts it as an integer
     */
    private function getDay($day)
    {
        $value = 0;
        if (ctype_alpha($day)) {
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
