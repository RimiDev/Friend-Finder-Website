<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Friend;
use App\User;
use App\Course;
use App\User_course;
use App\Course_teacher;
use App\Classes;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
        foreach ($friendStatus as $friend)
            $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

        $courseTitleTeacher = self::getUserCourses('1');
        $courseTimeDaySection = self::getUserCourses('2');

        if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0) {
            if ($courseTitleTeacher == null || $courseTimeDaySection == null) { //have friends, dont have courses
                return view('home', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
            } else { //have friends & courses
                return view('home',
                    ['friendNames' => $friendNames, 'friendStatus' => $friendStatus, 'courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection,
                        'errorMessage' => 'Find your courses here']);
            }
        }
        else if($courseTitleTeacher != null || $courseTimeDaySection != null){ //no friends, courses?
            return view('home',
                ['courseTitleTeacher' => $courseTitleTeacher,
                    'courseTimeDaySection' => $courseTimeDaySection,
                    'errorMessage' => 'Find your courses here']);
        }
        else{ //no friends & no courses
            return view('home');
        }

    }

    public function searchSaveUpdateFriends(Request $request)
    {
        if ($request->get('submitFriendSearch'))
        {
            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
                return view('home', ['friendNames' => $friendNames,
                    'friendStatus' => $friendStatus]);
            return view('home');
        }

        else if ($request->get('addFriendBtn'))
        {
            $this->saveFriend($request);

            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            return view('home', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
        }

        else if ($request->get('acceptRequest'))
        {
            $this->acceptFriendRequest($request);

            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
                return view('home', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
            return view('home');
        }
        else if ($request->get('declineRequest'))
        {
            $this->declineFriendRequest($request);

            $friendStatus = Friend::where(('email'), '=', Auth::user()->email)->get();
            foreach ($friendStatus as $friend)
                $friendNames[] = User::where('email', '=', $friend->friendEmail)->first();

            if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
                return view('home', ['friendNames' => $friendNames, 'friendStatus' => $friendStatus]);
            return view('home');
        }
    }
    
    private function saveFriend(Request $request)
    {
        $checkExists = Friend::where('email', '=', Auth::user()->email)->
            where('friendEmail', '=', $request->get('addFriendBtn'))->get();

        if (count($checkExists) <= 0)
        {
            $friend = new Friend();
            $friend->email = Auth::user()->email;
            $friend->user_id = Auth::user()->id;
            $friend->status = 'Request Sent';
            $friend->friendEmail = $request->get('addFriendBtn');
            $friend->save();

            $friend = new Friend();
            $friend->email = $request->get('addFriendBtn');
            $friend->user_id = Auth::user()->id;
            $friend->status = 'Request Received';
            $friend->friendEmail = Auth::user()->email;
            $friend->save();
        }
    }

    private function acceptFriendRequest(Request $request)
    {
        Friend::where('email', '=', Auth::user()->email)->
        where('friendEmail', '=', $request->get('acceptRequest'))->update(['status' => 'Confirmed']);

        Friend::where('email', '=', $request->get('acceptRequest'))->
        where('friendEmail', '=', Auth::user()->email)->update(['status' => 'Confirmed']);
    }

    private function declineFriendRequest(Request $request)
    {
        Friend::where('email', '=', Auth::user()->email)->
            where('friendEmail', '=', $request->get('declineRequest'))->delete();

        Friend::where('email', '=', $request->get('declineRequest'))->
            where('friendEmail', '=', Auth::user()->email)->delete();
    }
    
    public function getUserCourses(String $req){
        //Select all Course ids that the user has.
        $courseIdsThatUserHas = User_course::where('email','=', Auth::user()->email)->get();

        //This will grab the courseTitles from the course ids that the user has.
        if (count($courseIdsThatUserHas)){
            foreach ($courseIdsThatUserHas as $value) {
                $courseTimeDaySection[] = Course::where('id','=',$value->course_id)->first();
            }

            foreach($courseTimeDaySection as $value) {
                $courseTitleTeacher[] = Course_teacher::where('courseID', '=', $value->courseID)->first();
            }

            if ($req == '1' ){
                return $courseTitleTeacher;
            } else {
                return $courseTimeDaySection;
            }

        } else {
            return null;
        }

    } // end of getUserCourses
}
