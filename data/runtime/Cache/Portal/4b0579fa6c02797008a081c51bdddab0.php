<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<title><?php echo ($post_title); ?> <?php echo ($site_name); ?> </title>
	<meta name="keywords" content="<?php echo ($post_keywords); ?>" />
	<meta name="description" content="<?php echo ($post_excerpt); ?>">
		<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/base.css"/>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/top.css"/>
		
	<script src="/statics/js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<script src="/statics/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="/tpl/v1/Public/js/lib/html5.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/main.js" type="text/javascript" charset="utf-8"></script>
	<script src="/tpl/v1/Public/js/placeholder.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.ext.css"/>
    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/main.css"/>	
	<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/css/special.css"/>
</head>
<body class="theme">	
	
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
	
	<div class="wrapper">
		<div class="wrap">
			<section class="bg-white">
				<div class="grid news-detail">
					<div class="slider">
	<div class="slider-hd">
		<h4>熱門資訊</h4>
	</div>
	<div class="slider-bd">							
		<ul class="items">							
			<?php $ads = sp_sql_ads("ad_content:news_left;field:*;limit:4;order:ad_id desc;"); ?>
	        <?php if(is_array($ads)): $i = 0; $__LIST__ = $ads;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
				<div class="imgbox">
					<a href="<?php echo sp_ad_path( $vo['ad_cate'], $vo['ad_link'] ) ?>" target="<?php echo ($vo[ad_target]); ?>">
					<img src="<?php echo ($vo["ad_imgurl"]); ?>"/></a>
				</div>
				<div class="item-intr">
					<a href=""><?php echo ($vo["ad_name"]); ?></a>
				</div>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
											
		</ul>
	</div>
</div>
					
					<div class="main grid-right">
						<div class="news-head">
							<div class="data-form">
								來源：<?php echo ($post_source); ?>
							</div>
							<h4><?php echo ($post_title); ?></h4>
							
						</div>
						<div class="news-top">
							<div class="share">
								<div class="share-box">
									<!-- JiaThis Button BEGIN -->
									<div class="jiathis_style">
										<span class="jiathis_txt">分享到：</span>
										<a class="jiathis_button_fb"></a>
										<a class="jiathis_button_twitter"></a>
										<a class="jiathis_button_tsina"></a>
										<a class="jiathis_button_email"></a>
										<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank">更多</a>
										<a class="jiathis_counter_style"></a>
									</div>
									<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=" charset="utf-8"></script>
									<!-- JiaThis Button END -->
								</div>
							</div>
							<p class="text-center">
								<?php echo ($post_date); ?>
							</p>
						</div>
						<div class="content">
							<?php echo ($post_content); ?>
						</div>
						
						 <!-- <div>
							<?php if(!empty($prev)): ?><a href="<?php echo U('article/index',array('id'=>$prev['tid']));?>" class="btn btn-primary pull-left">上一篇</a><?php endif; ?>
							<?php if(!empty($next)): ?><a href="<?php echo U('article/index',array('id'=>$next['tid']));?>" class="btn btn-warning pull-right">下一篇</a><?php endif; ?>
		    	           <script type="text/javascript" src="/tpl/v1/Public/js/qrcode.min.js"></script>
		                    <div id="qrcode" style="width: 100px;margin:0 auto"></div>
		    					<script type="text/javascript">
		                        var qrcode = new QRCode(document.getElementById("qrcode"), {
		                        width : 100,
		                        height : 100
		                        });
		                        function makeCode () {		
		                        	qrcode.makeCode("http://<?php echo ($_SERVER['HTTP_HOST']); echo ($_SERVER['REQUEST_URI']); ?>");
		                        }
		                        makeCode();
		                        </script>
		                       
							<div class="clearfix"></div>
						</div> -->
						<!-- 
						<?php echo Comments("posts",$object_id);?>
						-->
					</div>
				</div>
			</section>
			
			
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