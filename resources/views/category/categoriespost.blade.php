@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
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
                        @foreach($posts as $post)
                        <h4 class="text-center">{{$post->post_title}}</h4>
                      <div class="text-center"><img class="" src="{{ $post->image }}" height=250px; width=100%; alt=""></div>
                        <div class="" style="text-align: justify;"><p>{{ $post->post_body }}</p></div>

                       
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
        </div>
    </div>
</div>
@endsection
