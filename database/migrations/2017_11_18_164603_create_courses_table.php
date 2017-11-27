<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('classID');
            $table->integer('sectionID');
			$table->integer('courseID');
            $table->integer('day');
			$table->string('startTime');
			$table->string('endTime');
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
        
        for($i = 1; $i < count($class); $i++){
            if($i == 1){
                $temp = $class[$i];
                $classIDs[] = $classID;
                //$classNum[] = $class[$i];
            }
            else{
                if($temp == $class[$i]){
                    $classIDs[] = $classID;
                    //$classNum[] = $class[$i];
                }
                else{
                    $temp = $class[$i];
                    $classIDs[] = $classID;
                    //$classNum[] = $class[$i];
                    $classID++;
                }
            }
        }
        
        for($j = 1; $j < count($title); $j++){
            if($j == 1){
                $titleTemp = $title[$j];
                $courseIDs[] = $courseID;
                //$titles[] = $title[$j];
                $teachTemp = $teacher[$j];
                //$teachers[] = $teacher[$j];
            }
            else{
                if($titleTemp == $title[$j]){
                    if($teachTemp == $teacher[$j]){
                        $courseIDs[] = $courseID;
                        //$titles[] = $title[$j];
                        //$teachers[] = $teacher[$j]; 
                    }
                    else{
                        $courseID++;
                        $courseIDs[] = $courseID;
                        //$titles[] = $title[$j];
                        $teachTemp = $teacher[$j];
                        //$teachers[] = $teacher[$j];
                    }
                }
                else{
                    $courseID++;
                    $titleTemp = $title[$j];
                    $courseIDs[] = $courseID;
                    //$titles[] = $title[$j];
                    $teachTemp = $teacher[$j];
                    //$teachers[] = $teacher[$j];
                }
            }
        }
        
        
        for($x = 0; $x < count($day); $x++){
           DB::table('courses')->insert(array('classID'=>$classID, 'sectionID'=>$section[$x], 'courseID'=>$courseID[$x],
            'day'=>$day[$x], 'startTime'=>$start[$x], 'endTime'=>$end[$x])); 
        }        
        
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
