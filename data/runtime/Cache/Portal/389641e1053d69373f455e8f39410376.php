<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>申请职位</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <link rel="shortcut icon" href="http://localhost/zp/favicon.ico" />
    <meta name="author" content="XG人才招聘系统" />
    <meta name="copyright" content="XG人才招聘系统" />

    <link href="/tpl/v1/Public/zp/css/index.css" rel="stylesheet" type="text/css" />
    <link href="/tpl/v1/Public/zp/css/jobs.css" rel="stylesheet" type="text/css" />

    <link href="/tpl/v1/Public/zp/css/common.css" rel="stylesheet" type="text/css" />
    <link href="/tpl/v1/Public/zp/css/style.css" rel="stylesheet" type="text/css" />

    <script src="/tpl/v1/Public/js/jquery-1.11.1.min.js" type="text/javascript" language="javascript"></script>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/tpl/v1/Public/js/skin/layer.ext.css"/>
    <script src="/tpl/v1/Public/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
<div class="wrap">
    <!--头部start-->

    <!--头部end-->
    <!--主体部分-->
    <div id="main" class="main">

        <div id="job">
            <div class="apply" style="padding: 30px;">

                <h4>选择简历</h4>
                <div class="resume-list">
                    <ul>
                    <?php if(is_array($resume)): $i = 0; $__LIST__ = $resume;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><input type="radio" name="resumeid" class="resume_id" value="<?php echo ($vo["id"]); ?>" <?php if($i == 1): ?>checked<?php endif; ?>/>
                        <span><?php echo ($vo["title"]); ?></span>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>

                </div>

                <button class="btn btn-primary apply-btn">确定申请</button>
            </div>
        </div>
    </div>
    <!--主体部分end-->
    <!--底部start-->

    <!--底部end-->

</div>

<script>
$(".apply-btn").click(function () {
    var job_id = "<?php echo ($_GET['id']); ?>";
    var resume_id = $("input[name=resumeid]:checked").val();

    if(resume_id=='undefined'){
        layer.alert("请选择简历");
        return false;
    }
    $.ajax({
        url:"<?php echo U('User/Jobs/apply_job');?>",
        type:"POST",
        dataType:"json",
        data:{jid:job_id,rid:resume_id},
        success: function (data) {
            layer.alert(data.msg,function(){
                if(data.r==0){
                    history.go(-1);
                }
            });
            
        }
    })
});
</script>

</body>
</html>