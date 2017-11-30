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

      //Select all ids that the user has.
      $courseIdsThatUserHas = User_course::where('email','=', Auth::user()->email)->get();

      //This will grab the row of the table that has the
      //startTime,endTime,Section,Day.
      if (count($courseIdsThatUserHas) > 0){
        foreach ($courseIdsThatUserHas as $value) {
          $courseTimeDaySection[] = Course::where('id','=',$value->course_id)->first();
        }

        //This will grab the the row of the table that has the
        //Title of the course and teacher.
        foreach($courseTimeDaySection as $value) {
          $courseTitleTeacher[] = Course_teacher::where('courseID', '=', $value->courseID)->first();
        }

        return view('manageCourses',
                   ['courseTitleTeacher' => $courseTitleTeacher,
                    'courseTimeDaySection' => $courseTimeDaySection]);

      } else {
        return view('manageCourses');
      }

    } // end of index()

    public function courses(Request $request){

      //Select all Course ids that the user has.
      $courseIdsThatUserHas = User_course::where('email','=', Auth::user()->email)->get();

      //This will grab the courseTitles from the course ids that the user has.
      if (count($courseIdsThatUserHas)){
        foreach ($courseIdsThatUserHas as $value) {
          $courseTimeDaySection[] = Course::where('id','=',$value->course_id)->first();
        }

        //echo $coursesUserHas[0]->courseID;
        foreach($courseTimeDaySection as $value) {
          $courseTitleTeacher[] = Course_teacher::where('courseID', '=', $value->courseID)->first();
        }

      } // end if count(courseIdsThatUserHas)


      //TEACHER SEARCH-------------------------
      if ($request->get('submitCourseSearch')){

        //Check if the user wants to search for a course by teacher.
        if ($_POST['searchOption'] == 'teacher'){
          //This will grab the courseName that the user has searched for.
          $searchedCourses = Course_teacher::where('teacher', 'ilike', '%' .
          $request->get('searchedContent') . '%')->get();
          if (count($searchedCourses) > 0){
            return view('manageCourses',
                       ['teacherSearch' => $searchedCourses,
                        'courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          } else {
            return view('manageCourses',
                       ['courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          }

        }

      } // End of teacher search


        //COURSE NUMBER SEARCH------------------------
        if ($_POST['searchOption'] == 'courseNumber'){

          //Grabbing the class ID for the course number.
          $searchClassId = Classes::where('classNumber', '=', $request->get('searchedContent'))->get();

          //If there are not classIDs, then there will be no results.
          if(count($searchClassId) > 0){
            //Search for the courseID depending on the classID.
            $searchCourseId = Course::where('courseID', '=', $searchClassId[0]->classID)->get();
            //Iterate through the searchCourseId array to make an array of all the course titles/teacher names
            //with the same courseID.
            foreach($searchCourseId as $courseIds){
            $searchCourseTitleAndTeacher[] = Course_teacher::where('courseID', '=', $courseIds->courseID)->first();
            }
            return view('manageCourses', ['courseNumberSearch' => $searchCourseTitleAndTeacher, 'completeCourses' => $coursesUserHas]);
          } else {
            return view('manageCourses', ['completeCourses' => $coursesUserHas]);
          }

        } // end of the COURSE NUMBER SEARCH--------------------------------

        if ($_POST['searchOption'] == 'courseTitle'){
          echo 'Hello';
        }

      } //end of submitCourseSearch POST REQUEST------


      //REMOVE && ADD BUTTONS

      //Remove button clicked on a specific course.
      if($request->get('removeCourseBtn')){


      }






    }// end of CourseController
