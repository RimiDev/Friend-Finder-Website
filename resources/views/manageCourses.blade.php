
@extends('layouts.app')

        <!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Courses</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
@section('content')
<div class="container">
  <h1> Manage courses </h1>
    <div class="navbar-header">
        <!--Side bar nav-->
        <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
            <li><a href="/manageFriends">Manage Friends</a></li>
            <li><a href="/findFriendBreaks">Find Friend Breaks</a></li>
        </ul>
    </div>
    <br/><br/><br/>

    <div id="block">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 id="boldText"> Courses </h3>
                </div>
                <div class="panel-body">
                  <form action="" method="post">
                  {{ csrf_field() }}
                @if(isset($courseTitleTeacher))
                @for ($i = 0; $i < count($courseTitleTeacher); $i++)
                  <h4 id="boldText">{{ $courseTitleTeacher[$i]->title . ' '
                       . $courseTitleTeacher[$i]->teacher }}</h4>
                       <?php
                       switch($courseTimeDaySection[$i]->day){
                                case 1: echo 'Monday';
                                        break;
                                case 2: echo 'Tuesday';
                                        break;
                                case 3: echo 'Wednesday';
                                        break;
                                case 4: echo 'Thursday';
                                        break;
                                case 5: echo 'Friday';
                                        break;
                       }
                       ?>
                      {{ $courseTimeDaySection[$i]->startTime . '-'
                       . $courseTimeDaySection[$i]->endTime . ' | Section: '
                       . $courseTimeDaySection[$i]->sectionID }}

                       <button id="removeButton" type="submit" value="{{$courseTimeDaySection[$i]->id}}"
                               name="removeCourseBtn">
                           Remove course
                       </button>


                  @endfor

                @else
                  <h4 id="boldText"> No courses registered </h4>
                @endif
                </form>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="block">
        <div class="panel panel-default">
            <div class="panel-heading">
                <form action="" method="post">
                    {{ csrf_field() }}
                    <h3 id="boldText">Search for courses:</h3>
                    <input type="radio" name="searchOption" value="teacher" checked> Teacher name</input>
                    <input type="radio" name="searchOption" value="courseNumber"> Course number</input>
                    <input type="radio" name="searchOption" value="courseTitle"> Course title</input>
                  </br>
                  </br>
                    <input id="textSearch" type="text" name="searchedContent">
                    <input type="submit" name="submitCourseSearch" value="Search">
                </form>
            </div>

            <div class="panel-body">
              <!--IF STATE
              <!--Teacher search-->
            @if(isset($teacherSearch[0]) && get_class($teacherSearch[0]) ==  'App\Course_teacher')
              @foreach($teacherSearch as $course)
                <h4>{{ $course->title . ' ' . $course->teacher }}</h4>
              @endforeach
            @endif

            <!--Course number search-->
            @if(isset($courseNumberSearch))
              @foreach($courseNumberSearch as $course)
                <h4>{{ $course->title . ' ' . $course->teacher }}</h4>
              @endforeach
            @endif

        </div>
</div>
</div>
</body>
</html>
@endsection
