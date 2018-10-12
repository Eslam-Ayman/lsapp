@extends('layouts.app')

@section('content')
	<h1>Create Post</h1>
	{!! Form::open(['action' => 'PostsController@store' , 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    	<div class="form-group">
    		{!! Form::label('title','Post Title') !!}
    		{{ Form::text("title" , '',['class' => 'form-control' , 'placeholder' => 'insert post title here...']) }}
    	</div>
    	<div class="form-group">
    		{{ Form::label('body' , 'Post Body') }}
    		{!! Form::textarea('body' , '', ['id' => 'article-ckeditor' , 'class' => 'form-control article-ckeditor' , 'placeholder' => 'inert the body of the Post']) !!}
    	</div>
    	<div class="form-group">
            {{ Form::file('image_name', ['class' => 'btn btn-success pull-right']) }}
            {{ Form::submit('Create Post' , ['class' => 'btn btn-primary']) }}
    	</div>
	{!! Form::close() !!}
@endsection