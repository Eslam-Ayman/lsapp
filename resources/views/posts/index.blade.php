@extends('layouts.app')

@section('content')
	<h1>Posts</h1>
	@if(count($posts) > 0)
		@foreach($posts as $post)
			<div class="well">
				<div class="row">
					<div class="col-xs-4">
						<img src="{{$post->image_name}}" class="img-responsive">
					</div>
					<div class="col-xs-8">
						<h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
						<small>written on {{$post->created_at}}</small>
						<div>{!!$post->body!!}</div>
						<hr>
						<p>the user name who written this <i><b>{{$post->usr->email}}</b></i></p>
					</div>
				</div>
				<!-- you can call function called dd($obj) which is stands for
				 debug dumb and pass your object as argument to show the 
				 structure and the content of the object you need  -->
			</div>
		@endforeach
	@else
		<p>no posts found</p>
	@endif
@endsection