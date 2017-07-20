
@extends('layout.main')
@section('content')

        <div class="col-sm-8 blog-main">
            <form action="/posts/{{$post->id}}" method="POST">
                {{--<input type="hidden" name="_method" value="PUT">--}}
                {{method_field('PUT')}}
                {{csrf_field()}}
                <div class="form-group">
                    <label>标题</label>
                    <input name="title" type="text" class="form-control" placeholder="这里是标题" value="@if(!empty(old('title'))){{old('title')}} @else {{$post->title}} @endif">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea id="content" name="content" class="form-control" style="height:400px;max-height:500px;"  placeholder="这里是内容" >@if(!empty(old('content'))){{old('content')}} @else {{$post->content}} @endif</textarea>
                </div>
                @include('layout.error')
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            <br>
        </div><!-- /.blog-main -->
@endsection
