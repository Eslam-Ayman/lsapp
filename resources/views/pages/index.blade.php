@extends('layouts.app')

@section('content')
	<div class="jumbotron text-center">
	  <h1>{{$title}}</h1>
	  <p>
	      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
	  </p>
	  <p>
	  	@if(Auth::guest())
		  	<a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
		  	<a class="btn btn-success btn-lg" href="/register" role="button">Register</a>
		<!-- actually you don't need those next parentheses -->
		@else()
			<a class="btn btn-primary btn-lg" href="/dashboard" role="button">Dashboard</a>
		<!-- those next parentheses are optional-->
		@endif()
	  </p>
	</div>
@endsection