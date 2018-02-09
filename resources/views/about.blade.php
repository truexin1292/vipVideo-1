
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
    @include('common.meta')
    <title>嗖嗖电影</title>
    <link href="css/mdui.css" rel="stylesheet" type="text/css">
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-primary-indigo mdui-theme-accent-pink mdui-loaded mdui-drawer-body-left ">
@include('common.header')
@include('common.navbar')

<div class="mdui-container">
    <div class="mdui-row mdui-typo">
        <h2 class="doc-chapter-title" >
            <span style="border-bottom: 1px solid #cccccc">关于本站</span>
        </h2>
    </div>
    <div class="mdui-row mdui-typo">
        <div class="mdui-row " style="margin-left: 2px;margin-right: 2px;">
           <p>
               本站所有视频采集自各个视频站，视频播放使用第三方接口，播放器上的广告与本站无关，说白了本站只是各个会员视频站的搬运工，为了方便大家看剧而采集数据并播放。若有意见或建议请留言。
           </p>
            <p>
                本站目前只采集电视剧与电影，若时间充裕考虑添加动漫等其他。
            </p>
        </div>
    </div>
</div>

@include('common.footer')


<script src="js/mdui.min.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="js/common.js"></script>
<script>
    var $$ = mdui.JQ;
    $$("#start").on('click',function(){
        var message= document.getElementById("message").value.trim();
        if(message==""){
            mdui.alert('请输入反馈信息!','错误');
            return false;
        }
        $$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            method: 'POST',
            url: 'feedback',
            data: {
                message:message
            },
            success: function (data) {
                //由JSON字符串转换为JSON对象
                var item = JSON.parse(data);
                if(item.status==1){
                    mdui.alert('反馈成功!','恭喜');
                    $$("#message").val('');
                    return false;
                }else if(item.status==0){
                    mdui.alert(item.msg,'错误');
                    return false;
                }
            }
        });
    })

</script>
</body>
</html>