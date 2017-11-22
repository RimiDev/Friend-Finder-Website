
@extends('layouts.app')


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
@endsection
