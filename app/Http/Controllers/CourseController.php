<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Course;
use App\User_course;
use App\Course_teacher;
use Auth;

class CourseController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getCourses(Request $request) {
        $session = $request->session();

        $couseArray = array();
    }

    public function index(){

      //Select all Course ids that the user has.
      $courseIdsThatUserHas = User_course::where('email','=', Auth::user()->email)->get();

      //This will grab the courseTitles from the course ids that the user has.
      if (count($courseIdsThatUserHas)){
        foreach ($courseIdsThatUserHas as $value) {
          $coursesUserHas[] = Course_teacher::where('courseID','=',$value->course_id)->first();
        }
        return view('manageCourses', ['completeCourses' => $coursesUserHas]);
      } else {
        return view('manageCourses');
      }
    }

    public function courses(Request $request){

      //Select all Course ids that the user has.
      $courseIdsThatUserHas = User_course::where('email','=', Auth::user()->email)->get();

      //This will grab the courseTitles from the course ids that the user has.
      if (count($courseIdsThatUserHas)){
        foreach ($courseIdsThatUserHas as $value) {
          $coursesUserHas[] = Course_teacher::where('courseID','=',$value->course_id)->first();
        }
      }

      if ($request->get('submitCourseSearch')){

        //Check if the user wants to search for a course by teacher.
        if ($_POST['searchOption'] == 'teacher'){
          //This will grab the courseName that the user has searched for.
          $searchedCourses = Course_teacher::where('teacher', 'ilike', '%' .
          $request->get('courseName') . '%')->get();
          if (count($searchedCourses) > 0){
            return view('manageCourses', ['courseSearches' => $searchedCourses,  'completeCourses' => $coursesUserHas]);
          } else {
            return view('manageCourses', ['completeCourses' => $coursesUserHas]);
          }
        }

        if ($_POST['searchOption'] == 'courseNumber'){
          echo 'Hello';
        }

        if ($_POST['searchOption'] == 'courseTitle'){
          echo 'Hello';
        }





      }

    }

}
