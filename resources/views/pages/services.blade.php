@extends('layouts.app')

@section('content')
	<h1>{{$title}}</h1>
	@if(count($list) > 0 )
		<ul class="list-group">
			@foreach($list as $item)
				<li class="list-group-item">{{$item}}</li>
			@endforeach
		</ul>
	@endif
@endsection