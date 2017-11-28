@extends('layouts.app')


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
        <br/><br/><br/>

        <div id="block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p> Friends </p>
                </div>
                <div class="panel-body">
                    <p>Friend1</p>
                    <p>Friend2</p>
                    <p>Friend3</p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div id="block">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form action="" method="post">
                        {{ csrf_field() }}
                        <label>Search for friends:
                            <input type="text" name="name">
                        </label>
                        <input type="submit" name="submitFriendSearch" value="Search">
                    </form>
                </div>
                <div class="panel-body">
                    @if( isset($friends) && count($friends) > 0)
                        @foreach($friends as $friend)
                                {{ $friend->name}}
                                <br />
                        @endforeach
                        @else
                            <p>No users with that name!</p>
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

</body>
@endsection
