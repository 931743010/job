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
<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.css"/>
<link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.ext.css"/>
<script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>







<body class="J_scroll_fixed">
<div class="wrap jj">
  <ul class="nav nav-tabs">
     <li class="active"><a href="<?php echo U('AdminCate/index');?>">分类管理</a></li>
     <li><a href="<?php echo U('AdminCate/add');?>">添加分类</a></li>
  </ul>
  <div class="common-form">
    <form method="post" class="J_ajaxForm" action="<?php echo U('AdminCate/listorders');?>">
      <div class="table_list">
	    <table width="100%" class="table table-hover">
	        <thead>
	          <tr>
	            <th width="80">排序</th>
	            <th width="100">ID</th>
	            <th>分类名称</th>
	            <!-- <th>分类类型</th> -->
	            <th align='center'>访问</th>
	            <th>操作</th>
	          </tr>
	        </thead>
	        <tbody>
	        	<?php echo ($taxonomys); ?>
			</tbody>
	      </table>
  </div>
  		<div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit J_ajax_submit_btn">排序</button>
      </div>
    </form>
  </div>
</div>
<script src="/statics/js/common.js?"></script>
</body>
</html>