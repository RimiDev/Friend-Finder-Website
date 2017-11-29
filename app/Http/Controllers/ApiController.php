<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Auth;
//use App\Friend;

class ApiController extends Controller
{
    // TODO : changes required to database

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function findallfriendsbyuser(Request $request) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        if (!valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            $friends = Friend::where('id', '=', Auth::user()->id)->get();
            return response()->json($friends, 200);
        }
    }

    /**
     * @param Request $request
     * @param $coursename
     * @param $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function findallfriendsbyclass(Request $request, $coursename, $section) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        if (!valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            // TODO : fetch the friends classes
            // Need to change the db structure
            $friendclass = array();
            $classesid = array();
            $friendclass = Course::where('courseNumber', '=', $coursename).get();
            $classesid = Course::where('courseNumber', '=', $coursename).get();
        }
    }

    /**
     * @param Request $request
     * @param $day
     * @param $starttime
     * @param $endtime
     * @return \Illuminate\Http\JsonResponse
     */
    public function findfriendbreaks(Request $request, $day, $starttime, $endtime) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        if (!valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            // TODO : fetch the friends breaks
            // Modifications to tables needed
        }
    }

    /**
     * @param Request $request
     * @param $friendemail
     * @param $day
     * @param $time
     * @return \Illuminate\Http\JsonResponse
     */
    public function findfriendlocation(Request $request, $friendemail, $day, $time) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        if (!valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {
            // TODO : fetch friend location
            // Modifications to tables needed
        }
    }
}
