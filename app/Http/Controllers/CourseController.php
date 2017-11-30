<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Friend;
use App\Course;
use App\User_course;
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
      $courseIdsThatUserHas = User_course::where('email','=',Auth::user()->email);

      //This will grab the courseTitles from the course ids that the user has.
      $coursesUserHas = Course::where('courseId','=',$courseIdsThatUserHas);
        return view('manageCourses', ['completeCourses' => $coursesUserHas]);

    }

    public function courses(Request $request){

      if ($request->get('submitCourseSearch')){

        //This will grab the courseName that the user has searched for.
        $coursesUserHas = Course::where('teacher', 'ilike', '%' . $request->get('courseName') . '%')->
            paginate(10);


      }

    }

}
