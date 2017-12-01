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
        <h1> Welcome to Dawson Friend Finder 2017 </h1>
        <div class="navbar-header">
            <!--Side bar nav-->
            <ul class="nav navbar-nav">
                <li><a href="/manageCourses">Manage Courses</a></li>
                <li><a href="/manageFriends">Manage Friends</a></li>
                <li><a href="/findFriendBreaks">Find Friend Breaks</a></li>
            </ul>
        </div>
        <br/><br/><br/>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="block">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 id="boldText"> Homepage </h3>
                        </div>
                        <div class="panel-body1">
                            @if(isset($friendNames) && count($friendNames) > 0 && isset($friendStatus) && count($friendStatus) > 0)
                        @for($i = 0; $i < count($friendStatus); $i++)
                            <h4 id="boldText">
                    {{ $friendNames[$i]->name.' '.$friendNames[$i]->program.' '.$friendStatus[$i]->status }}

                                @if($friendStatus[$i]->status === 'Request Received')
                                    <form method="post" action="">
                                        {{ csrf_field() }}
                                        <button id="addButton" type="submit" name="declineRequest"
                                                value="{{$friendNames[$i]->email}}">
                                            Decline
                                        </button>
                                        <button id="addButton" type="submit" name="acceptRequest"
                                                value="{{$friendNames[$i]->email}}">
                                            Accept
                                        </button>
                                    </form>
                                @elseif($friendStatus[$i]->status === 'Confirmed')
                                    <form method="post" action="">
                                        {{ csrf_field() }}
                                        <button id="addButton" type="submit" name="declineRequest"
                                                value="{{$friendNames[$i]->email}}">
                                            Delete
                                        </button>
                                    </form>
                            </h4>
                            @endif
                        @endfor
                    @endif
                        </div>
                    </div>
                </div>

                <div id="block">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <p> blah </p>
                        </div>
                        <div class="panel-body2">
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
    </div>
@endsection
</body>
</html>
