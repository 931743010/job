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
<div class="wrap J_check_wrap">
  <ul class="nav nav-tabs">
     <li class="active"><a href="javascript:;">所有商品</a></li>
     <li><a href="<?php echo U('AdminGoods/add');?>"  target="_self">添加商品</a></li>
  </ul>
  <form class="well form-search" method="post" action="<?php echo u('AdminGoods/index');?>">
    <div class="search_type cc mb10">
      <div class="mb10"> 
        <span class="mr20">分类：
        <select name="cate_id" class="input-medium">
			<option value="">所有分类</option>
			<?php if(is_array($cate)): foreach($cate as $key=>$vo): $selected=$formget['cate_id']==$vo['id']?"selected":"" ?>
	        	<option value="<?php echo ($vo["id"]); ?>" <?php echo ($selected); ?>><?php echo ($vo["spacer"]); echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
		</select>
		&nbsp;&nbsp;品牌：
		<select name="brand_id" class="input-medium">
          <option value="">所有品牌</option>
          <?php if(is_array($brand)): $i = 0; $__LIST__ = $brand;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $selected=$formget['brand_id']==$vo['id']?"selected":"" ?>
          	<option value="<?php echo ($vo['id']); ?>" <?php echo ($selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
         </select> 
        
		<select name="intro_type" class="input-small">
			<option value="">全部</option>
			<option value="isnew" <?php echo $formget['intro_type']=='isnew'?"selected":"" ?>>最新</option>
			<option value="ishot" <?php echo $formget['intro_type']=='ishot'?"selected":"" ?>>热卖</option>
			<option value="isprice" <?php echo $formget['intro_type']=='isprice'?"selected":"" ?>>特价</option>
			<option value="isrec" <?php echo $formget['intro_type']=='isrec'?"selected":"" ?>>推荐</option>
			<option value="all_type" <?php echo $formget['intro_type']=='all_type'?"selected":"" ?>>全部推荐</option>
		</select>
        <select name="supplier_id" class="input-medium">
        	<option value="">全部</option>
          	<?php if(is_array($supplier)): $i = 0; $__LIST__ = $supplier;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $selected= $formget[suppliers_id] == $vo['id']?"selected":"" ?>
          		<option value="<?php echo ($vo['id']); ?>" <?php echo ($selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
         </select>
        <select name="isdown" class="input-small">
	         <option value="">全部</option>
	         <option value="1" <?php echo $formget[isdown]=='1'?"selected":"" ?>>上架</option>
	         <option value="0" <?php echo $formget[isdown]=='0'?"selected":"" ?>>下架</option>
        </select> 
        &nbsp;&nbsp;时间：
        <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width:80px;" autocomplete="off">-<input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width:80px;" autocomplete="off">
        
               &nbsp; &nbsp;关键字：
        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入关键字">
        <input type="submit" class="btn btn-primary" value="搜索"/>
        </span>
      </div>
    </div>
  </form>
  <form class="J_ajaxForm" action="" method="post">
    <div class="table_list">
      <table width="100%" class="table table-hover">
        <thead>
	          <tr>
	            <th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
	            <th width="15">ID</th>
	            <th>名称</th>
	            <th>货号</th>
                <th>价格</th>
                <th>库存</th>
                <th width="30">上架</th>
	            <th width="30">最新</th>
	            <th width="30">热卖</th>
	            <th width="30">特价</th>
	            <th width="30">推荐</th> 
	            <th width="120">操作</th>
	          </tr>
        </thead>
        	<?php if(is_array($goods)): foreach($goods as $key=>$vo): ?><tr>
		            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>" ></td>
		            <td><a><?php echo ($vo["id"]); ?></a></td>
		            <td>
		            	<a href="<?php echo U('goods/goods/index',array('id'=>$vo['id']));?>" target="_blank">
		            		<span><?php echo ($vo["name"]); ?></span>
		            	</a>
		            </td>
		            <td><?php echo ($vo["serial"]); ?></td>
		            <td><?php echo ($vo["price"]); ?></td>
		            <td><?php echo ($vo["stock"]); ?></td>
		            <td><a href="<?php echo U('AdminGoods/setstatus',array('type'=>'isdown','id'=>$vo['id'], 'mo'=>'Goods'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["isdown"],true);?></a></td>
		            <td><a href="<?php echo U('AdminGoods/setstatus',array('type'=>'isnew','id'=>$vo['id'], 'mo'=>'Goods'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["isnew"],true);?></a></td>
                    <td><a href="<?php echo U('AdminGoods/setstatus',array('type'=>'ishot','id'=>$vo['id'], 'mo'=>'Goods'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["ishot"],true);?></a></td>
                    <td><a href="<?php echo U('AdminGoods/setstatus',array('type'=>'isprice','id'=>$vo['id'], 'mo'=>'Goods'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["isprice"],true);?></a></td>
                    <td><a href="<?php echo U('AdminGoods/setstatus',array('type'=>'isrec','id'=>$vo['id'], 'mo'=>'Goods'));?>" class="J_ajax_setStatus"><?php echo getStatus($vo["isrec"],true);?></a></td>                    
                    <td>
                   	 	<a href="javascript:open_iframe_dialog('<?php echo u('comment/CommentGoodsadmin/index',array('post_id'=>$vo['id']));?>','评论列表')">查看评论</a> |
		            	<a href="<?php echo U('AdminGoods/edit',array('id'=>$vo['id']));?>">修改</a> |
		            	<a href="<?php echo U('AdminGoods/delete',array('id'=>$vo['id']));?>" class="J_ajax_del">删除</a>
					</td>
	          	</tr><?php endforeach; endif; ?>
          	<tr>
          		<td colspan="13">
          			<div style="float:left;">
          			<label class="checkbox inline" for="check_all">
          			<input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y" id="check_all">全选</label>                
			        </div>
			        <div style="float:left; padding-left:8px;">
			        <select id="selAction" name="type" class="input-medium">
					    <option value="isdown" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isdown','value'=>1, 'mo'=>'Goods'));?>">上架</option>
					    <option value="not_isdown" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isdown','value'=>0, 'mo'=>'Goods'));?>">下架</option>
					    <option value="isnew" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isnew','value'=>1, 'mo'=>'Goods'));?>">最新</option>
					    <option value="not_isnew" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isnew','value'=>0, 'mo'=>'Goods'));?>">取消最新</option>
					    <option value="ishot" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'ishot','value'=>1, 'mo'=>'Goods'));?>">热卖</option>
					    <option value="not_ishot" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'ishot','value'=>0, 'mo'=>'Goods'));?>">取消热卖</option>
					    <option value="isprice" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isprice','value'=>1, 'mo'=>'Goods'));?>">特价</option>
					    <option value="not_isprice" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isprice','value'=>0, 'mo'=>'Goods'));?>">取消特价</option>
					    <option value="isrec" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isrec','value'=>1, 'mo'=>'Goods'));?>">推荐</option>
					    <option value="not_isrec" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isrec','value'=>0, 'mo'=>'Goods'));?>">取消推荐</option>
					    <option value="delete" data-action="<?php echo u('AdminGoods/delete');?>">回收站</option>
					    <option value="move_to" data-action="<?php echo u('AdminGoods/move_to_cate');?>">转移到分类</option>
						<option value="suppliers_move_to" data-action="<?php echo u('AdminGoods/move_to_supplier');?>">转移到供货商</option>						    
					  </select>
					 </div>
					  <div style="float:left; padding-left:8px;"><select id="move_cate_id" name="move_cate_id" class="input-medium" style="display:none;">
							<option value="">所有分类</option>
							<?php if(is_array($cate)): foreach($cate as $key=>$vo): $selected=$formget['cate_id']==$vo['id']?"selected":"" ?>
					        	<option value="<?php echo ($vo["id"]); ?>" <?php echo ($selected); ?>><?php echo ($vo["spacer"]); echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
						</div>
						<div style="float:left; padding-left:8px;">
						<select id="move_supplier_id" name="move_supplier_id" class="input-medium" style="display:none;">
				        	<option value="">全部</option>
				          	<?php if(is_array($supplier)): $i = 0; $__LIST__ = $supplier;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $selected= $formget[suppliers_id] == $vo['id']?"selected":"" ?>
				          		<option value="<?php echo ($vo['id']); ?>" <?php echo ($selected); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				         </select>
				         </div>
					  <div style="float:left; padding-left:8px;">
					  	<button class="btn btn-primary J_ajax_submit_btn" type="submit" id="btnSure" data-action="<?php echo u('AdminGoods/setstatus',array('type'=>'isdown','value'=>1, 'mo'=>'Goods'));?>" data-subcheck="true">确定</button>
					  </div> 
          		</td>
          	</tr>
          </table>
          <div class="pagination"><?php echo ($Page); ?></div>
     
    </div>
  </form>
</div>
<script src="/statics/js/common.js"></script>
<script>

function refersh_window() {
    var refersh_time = getCookie('refersh_time');
    if (refersh_time == 1) {
        window.location="<?php echo u('AdminGoods/index',$formget);?>";
    }
}
setInterval(function(){
	refersh_window();
}, 2000);
$(function () {	
	$('#selAction').change(function () {
		var val = $("#selAction").val();
		if( val == 'move_to' ){
			if( $('#move_supplier_id').css('display') != 'none' )
				$('#move_supplier_id').css('display', 'none');
			$('#move_cate_id').css('display', 'block');
		} else if( val == 'suppliers_move_to' ){
			if( $('#move_cate_id').css('display') != 'none' )
				$('#move_cate_id').css('display', 'none');
			$('#move_supplier_id').css('display', 'block');
		} else {
			if( $('#move_cate_id').css('display') != 'none' )
				$('#move_cate_id').css('display', 'none');
			if( $('#move_supplier_id').css('display') != 'none' )
				$('#move_supplier_id').css('display', 'none');
		}
		var action = $("#selAction option:selected").attr("data-action");
		$("#btnSure").attr("data-action", action);
    });
	
	setCookie("refersh_time",0);
    Wind.use('ajaxForm','artDialog','iframeTools', function () {
        //批量移动
        $('#J_Content_remove').click(function (e) {
            var str = 0;
            var id = tag = '';
            $("input[name='ids[]']").each(function () {
                if ($(this).attr('checked')) {
                    str = 1;
                    id += tag + $(this).val();
                    tag = ',';
                }
            });
            if (str == 0) {
				art.dialog.through({
					id:'error',
					icon: 'error',
					content: '您没有勾选信息，无法进行操作！',
					cancelVal: '关闭',
					cancel: true
				});
                return false;
            }
            var $this = $(this);
            art.dialog.open("/index.php?g=portal&m=AdminGoods&a=move&ids=" + id, {
                title: "批量移动",
                width:"80%"
            });
        });
    });
});


</script>
</body>
</html>