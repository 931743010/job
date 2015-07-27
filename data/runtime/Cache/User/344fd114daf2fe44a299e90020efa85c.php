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
     <li class="active"><a href="<?php echo U('User/userinfo');?>">个人信息</a></li>
  </ul>
  <div class="common-form">
    <form class="form-horizontal J_ajaxForm" method="post" action="<?php echo U('User/userinfo_post');?>">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="input01">昵称:</label>
            <div class="controls">
              <?php echo ($user["user_realname"]); ?>
            </div>
          </div>

          <div class="control-group">
            <label class="control-label" for="input01">类型:</label>
            <div class="controls">
              <?php if($vo["utype"] == 0): ?><span style='color:#ccc'>未知</span>
	            	 <?php elseif($vo["utype"] == 1): ?>
	            	 	<span style='color:red'>个人</span>
	            	 	<?php else: ?>
	            	 	<span style='color:blue'>企业</span><?php endif; ?>
            </div>
          </div>

          

          <div class="control-group">
            <label class="control-label" for="input01">邮箱:</label>
            <div class="controls">
              <?php echo ($user["user_login"]); ?>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">账户余额:</label>
            <div class="controls">
              <?php echo ($account["money"]); ?>
            </div>
          </div>
          

          <div class="control-group">
            <label class="control-label" for="input01">认证状态:</label>
            <div class="controls">
            <?php $audit_arr = ['未验证',"	<span style='color:#f40'>验证中</span>","<span style='color:red'>验证通过</span>","<span style='color:#ccc'>验证不通过</span>"]; ?>
             	<?php echo ($audit_arr[$account['audit']]); ?>

            </div>
          </div>

		<div class="control-group">
            <label class="control-label" for="input01">认证资料:</label>
            <div class="controls">
              <?php if(($account["audit"] != 0) AND ($user["utype"] == 1)): ?><p>
	              	<span>身份证姓名：<?php echo ($account["person_name"]); ?></span>
	              	<span>身份证号码：<?php echo ($account["person_id"]); ?></span>
	              </p>
	              <p>
	              	<span>身份证正面：</span>
	              	<img src="<?php echo ($account["identify_z"]); ?>">
	              </p>
	              <p>
	              	<span>身份证反面：</span>
	              	<img src="<?php echo ($account["identify_f"]); ?>">
	              </p>
              <elseif condition='($account.audit neq 0) AND ($user.utype eq 2)'>

				<p>
	              	<span>营业执照号：<?php echo ($account["company_id"]); ?></span>
	              	
	              </p>
	              <p>
	              	<span>营业执照：</span>
	              	<img src="<?php echo ($account["license"]); ?>">
	              </p>
	              <p>
	              	<span>身份证反面：</span>
	              	<img src="<?php echo ($account["identify_f"]); ?>">
	              </p><?php endif; ?>
            </div>
         </div>

          
          <div class="form-actions">
            <button type="submit" class="btn btn-primary btn_submit  J_ajax_submit_btn">更新</button>
          </div>
        </fieldset>
      </form>
  </div>
</div>
<script src="/statics/js/common.js"></script>

</body>
</html>