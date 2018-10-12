@extends('layouts.app')

@section('content')
	<h1>Edit Post</h1>
	{!! Form::open(['action' => ['PostsController@update', $post->id] , 'method'=>'put', 'enctype'=>'multipart/form-data']) !!}
		<div class="form-group">
			{{Form::label('title' , 'New Title')}}
			{{Form::text('title' , $post->title , ['class'=>'form-control' , 'placeholder' => 'change the title'])}}
		</div>
		<div class="form-group">
			{{Form::label('body','New Body')}}	
			{{Form::textarea('body',$post->body , ['id'=>'article-ckeditor','class'=>'form-control'])}}
		</div>
		{{ Form::file('image_name', ['class' => 'btn btn-success pull-right']) }}
		{{Form::submit('Update' , ['class' => 'btn btn-primary'])}}
		<a href="/posts/{{$post->id}}" class="btn btn-default">Cancel</a>
		<!-- {{Form::hidden('_method','PUT')}} -->
	{!! Form::close() !!}
@endsection