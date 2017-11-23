@extends('layouts.app')

        <!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
@section('content')
    <div class="container">
        <h1> Manage Friends </h1>
        <div class="navbar-header">
            <!--Side bar nav-->
            <ul class="nav navbar-nav">
                <li><a href="/">Home</a></li>
                <li><a href="/manageCourses">Manage Courses</a></li>
                <li><a href="/findFriendBreaks">Find Friend Breaks</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>>
@endsection
