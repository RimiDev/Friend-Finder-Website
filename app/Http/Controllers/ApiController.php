<?php

namespace App\Http\Controllers;

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
    public function allfriends(Request $request) {
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

    public function coursefriends(Request $request) {
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
        $friendEmails= array();
        foreach($friendNames as $f) {
            $friendEmails[] = $f->email;
        }

        // Array of courses
        $friendCourses = array();
        for ($i = 0;$i < count($friendEmails); $i++) {
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
    public function friendbreaks(Request $request) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        $day = $request->get('day');
        $start = $request->get('starttime');
        $end = $request->get('endtime');

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {

        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function whereisfriend(Request $request) {
        //check credentials
        $credentials = $request->only('email', 'password');
        $valid = Auth::once($credentials);

        $friendemail = $request->get('email');
        $day = $request->get('day');
        $time = $request->get('time');

        if (!$valid) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        } else {

        }
    }

}
