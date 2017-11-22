
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

        <!-- Styles -->
        <style>

        .panel-body1 {
          text-align:left;

        }
        .panel-body2 {
          text-align:right;
          float: right;
        }

        </style>



<body>
@section('content')
<div class="container">
  <h1> Welcome to Dawson Friend Finder 2017 </h1>
  <div class="navbar-header">
    <!--Side bar nav-->
    <ul class="nav navbar-nav">
        @include('includes.header')
    </ul>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                </div>

                <div class="panel-body1">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p> blah </p>


                </div>

                <div class="panel-body2">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p> blah </p>


                </div>


            </div>
        </div>
    </div>
</div>
@endsection

</body>


</html>
