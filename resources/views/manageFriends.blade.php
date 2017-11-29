@extends('layouts.app')


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Manage Friends</title>

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
                    <h3 id="boldText"> Friends </h3>
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
                        <h3 id="boldText">Search for friends:</h3>
                        <input id="textSearch" type="text" name="name">
                        <input type="submit" name="submitFriendSearch" value="Search">
                    </form>
                </div>

                <div class="panel-body">
                    @if( isset($friends) && count($friends) > 0)
                        @foreach($friends as $friend)
                            <form action="" method="post">
                                {{ csrf_field() }}

                                <?php if(isset($status) && count($status) > 0)
                                     foreach($status as $value)
                                         $allFriends[] = $value->friendEmail;
                                ?>

                                @if(isset($allFriends))

                                    @if(in_array($friend->email, $allFriends))
                                        <h4 id="boldText">{{ $friend->name.' '.$friend->program. ' '. $value->status}}</h4>
                                    @else
                                        <h4 id="boldText">{{ $friend->name.' '.$friend->program}}
                                            <button id="addButton" type="submit" value="{{$friend->email}}"
                                                    name="addFriendBtn">
                                                Add Friend
                                            </button>
                                        </h4>
                                    @endif
                                    @else
                                    <h4 id="boldText">{{ $friend->name.' '.$friend->program}}
                                        <button id="addButton" type="submit" value="{{$friend->email}}"
                                                name="addFriendBtn">
                                            Add Friend
                                        </button>
                                    </h4>
                                @endif

                            </form>

                        @endforeach
                        <br/>
                        {{ $friends->links() }}
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