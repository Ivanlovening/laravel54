@extends('layout.main')
@section('content')

        <div class="col-sm-8 blog-main">
            <form action="/posts" method="POST">
                {{--隐藏域防止csrf攻击--}}
                {{csrf_field()}}
                <div class="form-group">
                    <label>标题</label>
                    <input name="title" value="{{old('title')}}" type="text" class="form-control" placeholder="这里是标题">
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea id="content"  style="height:400px;max-height:500px;" name="content" class="form-control" placeholder="这里是内容">{{old('content')}}</textarea>
                </div>
                @include('layout.error')
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            <br>

        </div><!-- /.blog-main -->
@endsection


