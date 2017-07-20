@extends('layout.main')
@section('content')
    @if(!empty(session('success')))
        {{session('success')}}
        @endif
    <div class="col-sm-8 blog-main">
        <div class="blog-post">
            <div style="display:inline-flex">
                <h2 class="blog-post-title">{{$post->title}}</h2>
                {{--判断是否有权限，否则删除对应图标--}}
                @can('update',$post)
                <a style="margin: auto"  href="/posts/{{$post->id}}/edit">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                @endcan
                @can('delete',$post)
                <a style="margin: auto"  href="/posts/{{$post->id}}/delete">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
                @endcan
            </div>

            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}}<a href="/user/{{$post->user_id}}">{{$post->user->name}}</a></p>

            <p><p>{!!$post->content!!}<p><br></p></p>
            <div>
                {{--判断该用户是否已经对该文章赞了--}}
                @if($post->zan(\Auth::id())->exists())<a href="/posts/{{$post->id}}/unzan" type="button" class="btn btn-default btn-lg">取消赞</a>
                @else
                <a href="/posts/{{$post->id}}/zan" type="button" class="btn btn-primary btn-lg">赞</a>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">评论</div>

            <!-- List group -->
            <ul class="list-group">
                @foreach($post->comments as $comment)
                <li class="list-group-item">
                    <h5>{{$comment->created_at}} by {{$comment->user->name}}</h5>
                    <div>
                        {{$comment->content}}
                    </div>
                </li>
                    @endforeach
            </ul>
        </div>

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">发表评论</div>

            <!-- List group -->
            <ul class="list-group">
                <form action="/posts/{{$post->id}}/comment" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="post_id" value="{{$post->id}}"/>
                    <li class="list-group-item">
                        <textarea name="content" class="form-control" rows="10"></textarea>
                        <button class="btn btn-default" type="submit">提交</button>
                    </li>
                    @include('layout.error')
                </form>

            </ul>
        </div>

    </div><!-- /.blog-main -->
@endsection
