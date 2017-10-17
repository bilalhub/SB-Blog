@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
         @if(session('response'))
                  <dir class="alert alert-sussess">{{session('response')}}</dir>
                 @endif

            <div class="panel panel-default">
                <div class="panel-heading">Post View</div>
               

                <div class="panel-body">
                <div class="row">
                <div class="col-md-3">
                 <ul style="text-align: center;" class="list-group">
                   @if(count($categories) > 0)
                       @foreach($categories->all() as $category)
                       <li class="list-group-item"><a href='{{ url("category/$category->id") }}'>{{$category->category}}</a></li>
                       @endforeach
                   @else
                       <p>NO Category is found!</p>
                   @endif
                 </ul>
                 </div>
                  <div class="col-md-9">
                    @if(count($posts)>0)
                        @foreach($posts->all() as $post)
                        <h4 class="text-center">{{$post->post_title}}</h4>
                      <div class="text-center"><img class="" src="{{ $post->image }}" height=250px; width=100%; alt=""></div>
                        <div class="" style="text-align: justify;"><p>{{ $post->post_body }}</p></div>

                        <ul class="nav nav-pills">
                        <li role="presentation">
                          <a href='{{ url("/like/{$post->id}")}}'>
                            <span class="fa fa-thumbs-up"> Like ({{$likeCtr}})</span>
                          </a>
                        </li>
                        <li role="presentation">
                          <a href='{{ url("/dislike/{$post->id}")}}'>
                            <span class="fa fa-thumbs-down"> Dislike ({{$dislikeCtr}})</span>
                          </a>
                        </li>
                        <li role="presentation">
                          <a href='{{ url("/comment/{$post->id}")}}'>
                            <span class="fa fa-comment-o"> Comment </span>
                          </a>
                        </li>
                        </ul>
                        @endforeach
                    @else
                        <p>No Posts Available!</p>
                    @endif

                      <form method="POST" action='{{ url("/comment/{$post->id}") }}'>
                        {{ csrf_field() }}
                          <div class="form-group">
                                <textarea id="comment" rows="9" class="form-control" name="comment" required autofocus></textarea>
                                </div>
                                <div class="form-group">
                                <button type="submit" class="btn btn-primary"> Add Comment</button>
                                </div>
                                </form>


                            <h3>Comments</h3>
                             @if(count($comments)>0)
                                @foreach($comments as $comment)
                                  <p>{{ ($comment->comment) }}</p>
                                  <p>Posted by: {{ ($comment->name) }}</p>
                                  <hr/>
                                @endforeach
                              @else
                              <p>No Comments Posted!</p>
                             @endif
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
