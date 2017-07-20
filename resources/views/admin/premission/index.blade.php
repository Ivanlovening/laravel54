@extends('admin.layout.main')
@section('content')
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-10 col-xs-6">
                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">权限列表</h3>
                        </div>
                        <a type="button" class="btn " href="/admin/premissions/create" >增加权限</a>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody><tr>
                                    <th style="width: 10px">#</th>
                                    <th>权限名称</th>
                                    <th>描述</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($premissions as $premission)
                                <tr>
                                    <td>{{$premission->id}}</td>
                                    <td>{{$premission->name}}</td>
                                    <td>{{$premission->description}}</td>
                                    <td>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody></table>
                            {{$premissions->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
   @endsection