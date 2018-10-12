@extends('layouts.app')

@section('content')
	<a href="/posts" class="btn btn-default">Go Back</a>
		<h1>{{$post->title}}</h1>
		<div>{!!$post->body!!}</div>
		<hr>
		<img src="{{$post->image_name}}" class="img-responsive">
		<hr>
		<small>written on {{$post->created_at}}</small>
		<hr>
		<p>the user name who written this <i><b>{{$post->usr->email}}</b></i></p>
		<hr>
		@if(!Auth::guest())
			@if(Auth::user()->id == $post->usr->id)
				<a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>
				{!! Form::open(['action'=>['PostsController@destroy' , $post->id] , 'method'=>'delete' , 'class'=>'pull-right']) !!}
					<div class="form-group">
						{{Form::submit('Delete',['class' => 'btn btn-danger'])}}
					</div>
				{!! Form::close() !!}
			@endif
		@endif
	
@endsection