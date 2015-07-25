<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html dir="ltr" lang="zh" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> 在线聊天室</title>
<link rel="stylesheet" href="/tpl/v1/Public/zp/static/style.css" type="text/css" media="all" />
<script type="text/javascript" src="/tpl/v1/Public/zp/static/jquery.js"  media="all"></script>
<script type="text/javascript" src="/tpl/v1/Public/zp/static/jquery.websocket.js"  media="all"></script>
<script type="text/javascript">
WS_STATIC_URL = 'http://www.hmv.com/websocket/static';
WS_HOST = '127.0.0.1';
WS_PORT = 843;

$(function(){
    var t = $('.message');
    $.wsmessage( 'msg', function( data ){
        t.append( data );
        $('.message').animate( { scrollTop: $('.message')[0].scrollHeight } ,0 );
    });
    
    $.wsmessage( 'chat', function( data ){
        t.append( data );
        $('.message').animate( { scrollTop: $('.message')[0].scrollHeight } ,0 );
    });
    
    $.wsmessage( 'name', function( data ) {
        if ( data ) {
            $('.msg.info.name').remove();
        }
        
    });
    
    $.wsmessage( 'list', function( data ) {
        console.log(data);
        if ( !data ) {
            return false;
        }
        $.each( data, function( k, v ){
            if ( v[1] ) {
                var w = $( '<li>' + v[0] + '</li>' ).click(function(){
                    $('.send .chat').val( '@' + v[0] + ' ' );
                });
                $('.list ul').append( w );
            } else {
                $(".list ul li").each(function(){
                    if ( $(this).html() == v[0] ) {
                        $(this).remove();
                        return false;
                    }
                });
            }
        });
        $('.online').html( $('.list ul li').size() );
    });
    $.wsclose(function( data ){
        $(".list ul li").html('');
        $('.online').html( 0 );
        t.append( '<div class="msg info">连接已断开, 6秒后自动重试</div>' );
    });
    
    
    $.wsopen( function( data ) {
        console.log(data);
        t.append( '<div class="msg info">连接服务器成功</div>' );
        // var w = t.append( '<div class="msg info name">请输入你的名称:<input type="text" class="name" name="name"  /><input type="submit" class="submit" name="submit" value="确认" /></div>' );
        // w.find('.submit').click(function(){
            $.wssend('name=' + "<?php echo ($_SESSION['user']['user_realname']); ?>" );
        //     return false;
        // });
    });
    
    $('.send .submit').click(function(){
        if ( $('.send .chat').val() ) {
            $.wssend($.param( { chat : $('.send .chat').val(),uid:'<?php echo ($_SESSION['user']['id']); ?>',receive:'yqbaa' } ) );
            $('.send .chat').val('');
        }
        return false;
    });
    $('.send  .chat').keydown(function (e) {
        if ( ( e.ctrlKey && e.keyCode == 13 ) || ( e.altKey && e.keyCode == 83 ) ) {
            $('.send .submit').click();
            return false;
        }
    })
    $('.tool .empty').click(function(){
        t.html('');
    })
});
</script>
</head>
<body>
    <link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
<link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />

<div class="header" id="header">

    <div class="top">
        <div style="width: 980px;margin: 0 auto;">
            <div class="cl816">
                <div class="top-left fl">
                    <ul class="flul">
                        <li><span>城市：</span><span id="city"></span> <a href="<?php echo U('Portal/index/change_city');?>">[切换城市]</a></li>
                        <li><span>天气：</span> <span id="weather"> </span></li>
                    </ul>
                </div>
                <div class="top-right fr">
                    <ul class="flul">

                        <?php if($_SESSION['user']['id']): ?><li><?php echo ($_SESSION['user']['user_realname']); ?><a href="<?php echo U('User/my/index');?>">  您好</a></li>
                        <li><a href="<?php echo U('user/my/index');?>">会员中心</a></li>
                        <li><a href="<?php echo U('user/index/logout');?>">退出</a></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('User/Login/index');?>">登陆</a></li>
                        <li><a href="<?php echo U('User/register/index');?>">注册</a></li><?php endif; ?>
                        <!--<li><a href="<?php echo U('user/jobs/aejobs');?>">发布需求信息</a></li>-->
                    </ul>
                </div>

                <div class="c"></div>
            </div>
        </div>

    </div>
    <div class="h-center">
        <div class="head-banner">
            <img src="/tpl/v1/Public/zp/images/top-banner.gif" alt=""/>
        </div>
        <div class="h-center-bottom">
            <div class="logo fl"><a href="<?php echo U('Portal/Index/index');?>"><img src="/tpl/v1/Public/images/logo.png" alt="XG人才招聘系统" border="0" align="absmiddle" /></a></div>
            <div class="search fl">
                <form action="">
                    <input type="text" id="top-search" class="search-control" placeholder="请输入关键字查询" value=""/>
                    <button class="btn-search" id="search-btn">搜索</button>

                </form>
            </div>
            <div class="publish fl">
                <a href="<?php echo U('user/jobs/aejobs');?>" class="publish">发布信息</a>
            </div>
            <div class="c"></div>
        </div>
        <!--导航start-->
        <div class="nav">
            <ul class="flul">
                <li><a href="<?php echo U('Portal/Index/index');?>" target="_self">首  页</a><span class="shu"></span></li>

                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=126">家政服务</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=128">文化生活</a><span class="shu"></span></li>
                <li><a href="<?php echo U('Portal/Jobs/category');?>&catid=132">社区综合</a><span class="shu"></span></li>
            </ul>
        </div>
        <!--导航end-->
    </div>
    <script>
        <?php if($_SESSION['wiki']['cityId']> 0): ?>$(".top span#city").html("<?php echo ($_SESSION['wiki']['city']); ?>");
            $(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        <?php if($Think.session.wiki.weather): ?>$(".top span#weather").html("<?php echo ($_SESSION['wiki']['weather']); ?>");<?php endif; ?>
        if( $(".top span#weather").html()==''){
            $.ajax({
                url:"<?php echo U('Portal/Index/getWiki');?>",
                data:{},
                type:'POST',
                dataType:'json',
                success:function(data){
                    $(".top span#city").html(data.city);
                    $(".top span#weather").html(data.weather);
                }
            });
        }

        $("#search-btn").click(function (e) {
            var keyword = $("#top-search").val();
            var url = "<?php echo U('jobs/lists');?>&keyword="+keyword;
            location.href = url;
            return false;
        })
    </script>
</div>
    <div id="main" class="main">
        <div class="chat">
            <div class="chat-list fl">
                <ul>
                    <li> <a href="<?php echo U('chat/chat');?>&rid={10}">昵称</a></li>
                    <li> <a href="<?php echo U('chat/chat');?>&rid={10}">昵称</a></li>
                    <li> <a href="<?php echo U('chat/chat');?>&rid={10}">昵称</a></li>
                </ul>
            </div>
            <div class="content fl">
                <div class="message"></div>
                <div class="tool">
                    <span class="empty">清空记录</span>
                </div>
                <div class="send">
                    <textarea class="chat" name="chat"></textarea>
                    <p><input type="submit" class="submit" name="submit" value="发送" /></p>
                </div>
                <div class="list">
                    <h3>在线用户<strong class="online">0</strong></h3>
                    <ul>

                    </ul>
                </div>
            </div>
            <div class="c"></div>
        </div>
    </div>
    <!-- <div id="footer" class="footer">
    <div class="fmain autow">
        <div class="f-nav">
            <ul class="flul">
                <li><a href="">关于我们</a></li>
                <li><a href="">帮助中心</a></li>
                <li><a href="">联系我们</a></li>
                <li><a href="">加入我们</a></li>
            </ul>
        </div>
        <div class="c"></div>
        <div class="copy-right">
            <p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>
            <p>深圳市公安网络备案编号：10000000</p>
        </div>
    </div>
</div> -->
<div id="footer" class="footer">
        <div class="fmain autow">
            <div class="c"></div>
            <div class="copy-right">
                <!--<p>版权所有 2015-2018 公司名称 粤icp备：icp000000000</p>-->
                <p>版权所有: <a href="">© 人工在线</a></p>
                <p><a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备15056824</a></p>
            </div>
        </div>
    </div>

</body>
</html>