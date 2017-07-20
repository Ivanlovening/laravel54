@extends('admin.layout.main')
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-10 col-xs-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">文章详情</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                           <h4 style="font-weight:bold;text-align:center;">{{$post->title}}</h4>
                            <div style="text-indent: 2em;line-height:30px;">
                                {!!$post->content!!}
                            </div>
                            <div style="text-align:center;"><a href="/admin/posts">返回文章列表</a></div>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection