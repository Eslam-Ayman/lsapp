@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                    <a href="/posts/create" class="btn btn-primary btn-sm pull-right">Create Post</a>
                </div>

                <div class="panel-body">
                    You are logged in!
                    <h2>All {{Auth::user()->name}} posts</h2>
                    @if(count($posts) > 0 )
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Post Name</th>
                              <th>To Edit</th>
                              <th>To delete</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($posts as $post)
                            <tr>
                              <td><a href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                              <td><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></td>
                              <td>
                                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'delete']) !!}
                                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                                {!! Form::close() !!}
                              </td>
                            </tr>
                           @endforeach
                          </tbody>
                        </table>
                    @else
                        <p>there is no posts :(</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
