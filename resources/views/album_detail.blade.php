<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>视频列表</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left ">
@include('common.header')
@include('common.navbar')
<div class="mdui-container">

    <div class="mdui-col-lg-10 mdui-col-md-9">
        <div class="mdui-row mdui-typo">
            <h2 class="doc-chapter-title">
                @foreach($move_list as $move_lists)
                    @if($move_lists->movie_name)
                        {{$move_lists->movie_name}}
                        @break;
                    @endif
                @endforeach
            </h2>
            <p>剧集列表</p>
        </div>
         <hr/>
        <div class="mdui-row ">
                @forelse($move_list as $move_lists)
                <div class="mdui-col-md-4 mdui-col-xs-4 mdui-text-center" style="margin-top: 8px;">
                    <a href="http://vip.o11o.cc/play?url={{$move_lists->link}}&title={{$move_lists->movie_name}}&drama={{$move_lists->title}}" class="mdui-btn mdui-btn-raised mdui-ripple mdui-color-teal">{{$move_lists -> title}}</a>
                </div>
                @empty
                    无资源
                @endforelse
        </div>

    </div>
    <div class="mdui-col-lg-2 mdui-col-md-2"></div>
</div>
<div class="mdui-row" style="margin-top: 20px;">
    <div class="mdui-text-center" style="border-top:1px solid #cccccc">
        <p>2018©.<a href="https://vio.o11o.cc" class="mdui-text-color-pink">嗖嗖</a></p>
    </div>
</div>
<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>
<script type="text/javascript">
    $(function(){
        $("#gotop").click(function() {
            $("html,body").animate({scrollTop:0}, 500);
        });
    });

    $('img').error(function(){
        $(this).attr('src', "http://img.lanrentuku.com/img/allimg/1212/5-121204193R0-50.gif");
    });
</script>

</body>
</html>