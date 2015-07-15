<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/statics/js/artDialog/skins/default.css" rel="stylesheet" />
	
    <link href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">

	<![endif]-->

<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/statics/js/jquery.js"></script>
    <script src="/statics/js/wind.js"></script>
    <script src="/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap container-fluid">
    <ul class="nav nav-tabs">
        <li class="active"><a href="javascript:;">所有职位</a></li>

    </ul>

        <div class="search_type cc mb10 row-fluid">
            <div class="mb10 col-lg-3">
                <span class="mr20">分类：
                    <select name="catid" id="catid" class="input-medium">
                        <option value="-1">所有分类</option>
                        <?php echo ($cate); ?>
                    </select>
                </span>
                <span class="mr20">状态：
                    <select name="status" id="status" class="input-medium">
                        <option value="-1">所有状态</option>
                        <option value="0">审核中</option>
                        <option value="2">审核通过</option>
                        <option value="3">审核不通过</option>
                        <option value="4">下架</option>
                    </select>
                </span>
                <span class="mr20">关键字：
                    <input type="text" name="keyword" value="<?php echo ($keyword); ?>" id="keyword"/>
                </span>
                <span class="mr20">
                    <button id="search" class="btn btn-success">搜索</button>
                </span>
            </div>
        </div>

    <form class="J_ajaxForm" action="" method="post">
        <div class="table_list">
            <table width="100%" class="table table-hover">
                <thead>
                <tr>
                    <th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
                    <th width="15">ID</th>
                    <th>名称</th>
                    <th>分类</th>
                    <th>招聘人数</th>
                    <th>工作内容</th>
                    <th>工作性质</th>
                    <th>发布时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <?php if(is_array($jobs)): $i = 0; $__LIST__ = $jobs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" ></td>
                        <td><a><?php echo ($vo["id"]); ?></a></td>
                        <td>
                            <a href="<?php echo U('Portal/Jobs/detail',array('id'=>$vo['id']));?>" target="_blank">
                                <span><?php echo ($vo["job_name"]); ?></span>
                            </a>
                        </td>
                        <td><?php echo ($vo["category"]); ?></td>
                        <td><?php echo ($vo["person_num"]); ?></td>
                        <td><?php echo ($vo["job_desc"]); ?></td>
                        <td><?php echo ($vo["nature_name"]); ?></td>
                        <td><?php echo (date("Y-m-d",$vo["addtime"])); ?></td>
                        <td>
                            <?php if($vo["status"] == 0): ?>审核中
                                <?php elseif($vo["status"] == 2): ?>
                                审核通过
                                <?php elseif($vo["status"] == 3): ?>
                                审核不通过
                                <?php elseif($vo["status"] == 4): ?>
                                下架<?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo U('AdminJobs/delete');?>&id=<?php echo ($vo["id"]); ?>">删除</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>

            </table>
            <div class="pagination"><?php echo ($Page); ?></div>

        </div>
    </form>
</div>
<script src="/statics/js/common.js"></script>
<script>
    var url = "<?php echo U('AdminJobs/index');?>";
//    var catid = $("select[name=catid]");
//    var status = $("select[name=status]");
//    var keyword = $("input[name=keyword]");
    url+='&catid='+catid+"&status="+status+"&keyword="+keyword;
    $("#catid").change(function(){
        var catid = $(this).val();
        var status = $("select[name=status]").val();
        var keyword = $("input[name=keyword]").val();
        url+='&catid='+catid+"&status="+status+"&keyword="+keyword;
        location.href=url;
    });
    $("#status").change(function(){
        var status = $(this).val();
        var catid = $("select[name=catid]").val();
        var keyword = $("input[name=keyword]").val();
        url+='&catid='+catid+"&status="+status+"&keyword="+keyword;
        location.href=url;
    });
    $("#search").click(function () {
        var keyword = $("#keyword").val();
        var catid = $("select[name=catid]").val();
        var status = $("select[name=status]").val();
        url+='&catid='+catid+"&status="+status+"&keyword="+keyword;
        location.href=url;
        return false;
    });
    var catid = "<?php echo ($catid); ?>";
    $("#catid option").each(function () {
        if($(this).val()==catid){
            $(this).attr("selected",'selected');
        }
    });
    var status = "<?php echo ($status); ?>";
    $("#status option").each(function () {
        if($(this).val()==status){
            $(this).attr("selected",'selected');
        }
    });

</script>
</body>
</html>