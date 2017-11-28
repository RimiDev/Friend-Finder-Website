<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->increments('courseID');
            $table->string('title');
            $table->string('teacher');
        });

        $file = fopen('/database/migrations/FakeTeachersListW2017.csv', 'r');
        while(!feof($file)){
            $column = fgetcsv($file, ",");

            $class[] = $column[0];
            $section[] = $column[1];
            $title[] = $column[2];
            $teacher[] = $column[3];
            $day[] = $column[4];
            $start[] = $column[5];
            $end[] = $column[6];
        } 
        fclose($file);

        for($j = 1; $j < count($title); $j++){
            if($j == 1){
                $courseIDs[] = $courseID;
                $titleTemp = $title[$j];
                $titles[] = $title[$j];
                $teachTemp = $teacher[$j];
                $teachers[] = $teacher[$j];
            }
            else{
                if($titleTemp == $title[$j]){
                    if($teachTemp == $teacher[$j]){
                        //do nothing, this combination is already in the arrays
                    }
                    else{
                        $courseID++;
                        $courseIDs[] = $courseID;
                        $titles[] = $title[$j];
                        $teachTemp = $teacher[$j];
                        $teachers[] = $teacher[$j];
                    }
                }
                else{
                    $courseID++;
                    $courseIDs[] = $courseID;
                    $titleTemp = $title[$j];
                    $titles[] = $title[$j];
                    $teachTemp = $teacher[$j];
                    $teachers[] = $teacher[$j];
                }
            }
        }

        for($x = 0; $x < count($courseIDs); $x++){
            DB::table('course_teacher')->insert(array('courseID'=>$courseIDs[$x], 'title'=>$titles[$x], 'teacher'=>$teachers[$x]))
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_teacher');
    }
}
