@extends('layouts.app')
<style type="text/css">
    .avatar{
        border-radius: 100%;
        max-width: 100px;
    }
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="row">
                  <div class="col-md-4">Dashboard</div>
                  <div class="col-md-8">
                   <form method="POST" action='{{ url("/search") }}'>
                        {{ csrf_field() }}
                          <div class="input-group">
                                <input type="text" rows="9" class="form-control" name="search" placeholder="search for......">
                                <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"> GO!</button>
                                </div>
                                </form>

                </div>
                </div>
                </div>
                @if(count($errors) > 0)
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">[{$error}]</div>
                    @endforeach
                 @endif

                 @if(session('response'))
                  <dir class="alert alert-sussess">{{session('response')}}</dir>
                 @endif

                <div class="panel-body">
                <div class="row">
                <div class="col-md-4">
                @if($profile)
                  <img src="{{ $profile->profile_pic}}" height=20%; width=70%; class="avatar" alt="" />
                @else
                  <img src="{{ url('images/avatar.png')}}" height=20%; width=70%; class="avatar" alt="" />
                @endif

                 @if(!empty($profile))
                 <p class="lead" style="margin-bottom: 1px;">{{ $profile->name }}</p>
                @else
                  <p></p>
                @endif

                 @if(!empty($profile))
                  <p class="lead">{{ $profile->designation }}</p>
                @else
                  <p></p>
                @endif
                </div>

                <div class="col-md-8">
                    <div class="col-md-4">
 
                    </div>
                    <div class="col-md-8"></div>
                    @if(count($posts)>0)
                        @foreach($posts->all() as $post)
                        <h4 class="text-center">{{$post->post_title}}</h4>

                        <div class="text-center"><img class="" src="{{ $post->image }}" height=60%; width=100%; alt=""></div>
                        <div class="" style="text-align: justify;"><p>{{substr($post->post_body, 0, 101)}}</p></div>

                        <ul class="nav nav-pills">
                        <li role="presentation">
                          <a href='{{ url("/view/{$post->id}")}}'>
                            <span class="fa fa-eye"> VIEW</span>
                          </a>
                        </li>
                        <li role="presentation">
                          <a href='{{ url("/edit/{$post->id}")}}'>
                            <span class="fa fa-pencil-square-o"> EDIT</span>
                          </a>
                        </li>
                        <li role="presentation">
                          <a href='{{ url("/delete/{$post->id}")}}'>
                            <span class="fa fa-trash"> DELETE</span>
                          </a>
                        </li>
                          
                        </ul>


                        <cite style="">Posted on: {{date('M j,Y H:i', strtotime($post->updated_at))}}</cite>
                        <hr>
                        @endforeach
                    @else
                        <p>No Posts Available!</p>
                    @endif
                       

                       
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
