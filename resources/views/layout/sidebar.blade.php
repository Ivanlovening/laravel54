<div id="sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">


    <aside id="widget-welcome" class="widget panel panel-default">
        <div class="panel-heading">
            欢迎！
        </div>
        <div class="panel-body">
            <p>
                欢迎来到简书网站
            </p>
            <p>
                <strong><a href="/">简书网站</a></strong> 基于 Laravel5.4 构建
            </p>
        </div>
    </aside>
    <aside id="widget-categories" class="widget panel panel-default">
        <div class="panel-heading">
            专题
        </div>

        <ul class="category-root list-group">
           @foreach($topics as $topic)
            <li class="list-group-item">
                <a href="/topic/{{$topic->id}}">{{$topic->name}}
                </a>
            </li>
            @endforeach
        </ul>

    </aside>
</div>