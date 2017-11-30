
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
                @if($completeCourses != 'No courses to display')
                  @foreach($completeCourses as $course)
                  <h4>{{ $course->title . ' ' . $course->teacher }}</h4>
                  @endforeach
                @else
                  <h4> No courses to display </h4>
                @endif
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
                    <input id="textSearch" type="text" name="courseName">
                    <input type="submit" name="submitCourseSearch" value="Search">
                </form>
            </div>

            <div class="panel-body">




        </div>
</div>
</div>
</body>
</html>
@endsection
