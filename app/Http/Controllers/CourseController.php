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

      //return $courseTitleTeacher,$courseTimeDaySection;

    } // end of getUserCourses

    public function index(){

          //Get user courses
          $courseTitleTeacher = self::getUserCourses('1');
          $courseTimeDaySection = self::getUserCourses('2');

          if ($courseTitleTeacher == null || $courseTimeDaySection == null){
            return view('manageCourses');
          } else {
          return view('manageCourses',
                     ['courseTitleTeacher' => $courseTitleTeacher,
                      'courseTimeDaySection' => $courseTimeDaySection]);
         }


    } // end of index()


    public function courses(Request $request){

    //Get user courses
    $courseTitleTeacher = self::getUserCourses('1');
    $courseTimeDaySection = self::getUserCourses('2');


      //SEARCH------------------------------------------------------------------
      if ($request->get('submitCourseSearch')){

        //TEACHER SEARCH-------------------------
        if ($_POST['searchOption'] == 'teacher'){
          //This will grab the courseName that the user has searched for.
          $teacherSearch = Course_teacher::where('teacher', 'ilike', '%' .
          $request->get('searchedContent') . '%')->get();
          //If there aren't any teachers name that match the search, no results to display.
          if (count($searchedCourses) > 0){
            foreach($teacherSearch as $search){
            $timeDaySectionSearch[] = Course::where('courseID', '=', $search->courseID)->first();
          }
            
            return view('manageCourses',
                       ['teacherSearch' => $teacherSearch,
                        'courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          } else {
            //No results
            return view('manageCourses',
                       ['courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          }

        } // end of the TEACHER SEARCH------------------------------------------


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
            return view('manageCourses',
                       ['courseNumberSearch' => $searchCourseTitleAndTeacher,
                        'courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          } else {
            return view('manageCourses',
                       ['courseTitleTeacher' => $courseTitleTeacher,
                        'courseTimeDaySection' => $courseTimeDaySection]);
          }

        } // end of the COURSE NUMBER SEARCH------------------------------------

        if ($_POST['searchOption'] == 'courseTitle'){
          echo 'Hello';
        }

      } if ($request->get('removeCourseBtn')){
            //REMOVE && ADD BUTTONS
                //Remove button clicked on a specific course.
                User_course::where('course_id','=', $request->get('removeCourseBtn'))
                ->where('email', '=', Auth::user()->email)->delete();


                //Get user courses
                $courseTitleTeacher = self::getUserCourses('1');
                $courseTimeDaySection = self::getUserCourses('2');

                return view('manageCourses',
                           ['courseTitleTeacher' => $courseTitleTeacher,
                            'courseTimeDaySection' => $courseTimeDaySection]);
            } // end of the remove button //end of submitCourseSearch POST REQUEST------

    }// end of Course()

  }// end of CourseController
