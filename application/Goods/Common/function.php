<?php
/**
 * @todo goods serial
 */
function sp_sql_goods_serial($serial, $id) {
	$goods_model = M ( 'Goods' );
	if (! $serial) {
		$map ['DATE_FORMAT(create_date, "%Y-%m-%d")'] = array (
				'eq',
				date ( 'Y-m-d' ) 
		);
		$ret = $goods_model->field ( 'id' )->where ( $map )->order ( 'id desc' )->find ();
		$goods_id = $ret ['id'] + 1;
		$serial = C ( 'serial_prefix' ) . date ( 'Ymd' ) . str_repeat ( '0', 6 - strlen ( $goods_id ) ) . $goods_id;
	} else {
		$map = array ();
		$map ['serial'] = array (
				'eq',
				$serial 
		);
		if ($id)
			$map ['id'] = array (
					'neq',
					$id 
			);
		$re = $goods_model->field ( 'id' )->where ( $map )->find ();
		if ($re)
			return false;
		else
			return $serial;
	}
	return $serial;
}
/**
 *
 * @todo goods supplier
 */
function sp_sql_supplier() {
	$supplier = M ( 'Supplier' )->field ( 'id,name' )->where ( 'status=1' )->select ();
	return $supplier;
}
/**
 *
 * @todo goods type
 */
function sp_sql_types() {
	$types = M ( 'Type' )->field ( 'id,name' )->where ( 'status=1' )->select ();
	return $types;
}

/**
 *
 * @todo goods brand
 */
function sp_sql_brands() {
	$lists = D ( "Common/Brand" )->order ( array (
			"listorder" => "asc" 
	) )->select ();
	return $lists;
}
/**
 *
 * @todo goods gallery
 */
function sp_sql_gallery($pid) {
	$lists = M ( "Goods_gallery" )->where ( 'pid=' . $pid )->select ();
	return $lists;
}
/**
 *
 * @todo array to select
 * @param $arr 二位数组数据
 *        	$source_name 下拉框名称
 *        	$id 下拉框值
 *        	$name 下拉框内容
 * @return 下拉框 html
 */
function array_select($arr, $source_name = 'source_name', $id = 'id', $name = 'name') {
	$optionHtml = '<select multiple="true" ondblclick="" style="width:100%" size="20" name="' . $source_name . '" id="' . $source_name . '">';
	if ($arr) {
		foreach ( $arr as $ar ) {
			$optionHtml .= '<option value="' . $ar [$id] . '">' . $ar [$name] . '</option>';
		}
	}
	$optionHtml .= '</select>';
	return $optionHtml;
}
/**
 *
 * @todo 获取关联商品
 */
function sp_sql_link_goods($id) {
	$list = M ( 'Link_goods' )->field ( 'link_goods_id,name,is_double' )->join ( C ( 'DB_PREFIx' ) . 'goods g ON g.id = link_goods_id' )->where ( 'goods_id=' . $id )->select ();
	return $list;
}
/**
 *
 * @todo 获取关联文章
 */
function sp_sql_link_posts($id) {
	$list = M ( 'Link_posts' )->field ( 'posts_id,post_title' )->join ( C ( 'DB_PREFIx' ) . 'posts g ON g.id = posts_id' )->where ( 'goods_id=' . $id )->select ();
	return $list;
}
/**
 *
 * @todo 音乐分类
 *      
 */
function sp_sql_cate($parent = '') {
	// 音乐分类
	$map = array ();
	if ($parent) {
		$map ['parent'] = array (
				'eq',
				$parent 
		);
	}
	$cate = M ( 'Cate' )->where ( $map )->select ();
	return $cate;
}
/**
 * @ 处理标签函数
 * @ $tag以字符串方式传入,通过sp_param_lable函数解析为以下变量。例："cid:1,2;order:post_date desc,listorder desc;"
 * ids:调用指定id的一个或多个数据,如 1,2,3
 * cid:数据所在分类,可调出一个或多个分类数据,如 1,2,3 默认值为全部,在当前分类为:'.$cid.'
 * field:调用goods指定字段,如(id,name...) 默认全部
 * limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 * order:推荐方式(post_date) (desc/asc/rand())
 */
function sp_goods($tag, $where = array(), $pagesize = 20, $pagesetting = '') {
	$where = array ();
	$tag = sp_param_lable ( $tag );
	// var_dump($tag);
	$field = ! empty ( $tag ['field'] ) ? $tag ['field'] : 'g.*';
	$limit = ! empty ( $tag ['limit'] ) ? $tag ['limit'] : $pagesize;
	$order = ! empty ( $tag ['order'] ) ? $tag ['order'] : 'g.listorder,g.id desc';
	
	// 根据参数生成查询条件
	$where ['status'] = array (
			'eq',
			1 
	);
	$where ['isdown'] = array (
			'eq',
			1 
	);
	
	if (isset ( $tag ['preorder'] )) {
		$where ['preorder'] = array (
				'eq',
				$tag ['preorder'] 
		);
	}
	if (isset ( $tag ['cid'] )) {
		$where ['cate_id'] = array (
				'eq',
				$tag ['cid'] 
		);
	}
	$rs = M ( "Goods" );
	if (isset ( $tag ['attr_value'] )) {
		$where ['attr_value'] = array (
				'eq',
				$tag ['attr_value'] 
		);
		$join = "" . C ( 'DB_PREFIX' ) . 'goods_attr as a on g.id = a.goods_id';
		$totalsize = $rs->alias ( "g" )->join ( $join )->field ( $field )->where ( $where )->count ();
	} else {
		$totalsize = $rs->alias ( "g" )->field ( $field )->where ( $where )->count ();
	}
	import ( 'Page' );
	if (empty ( $PageParam )) {
		$PageParam = C ( "VAR_PAGE" );
	}
	$Page = new \Page ( $totalsize, $limit );
	$Page->SetPager ( 'default', '<div class="item-page"><ul class="pagination"><li class="prev disabled">{prev}</li><li>{list}</li><li>{next}</li></ul>{jump}</div>', array (
			"listlong" => "6",
			"first" => "首页",
			"last" => "尾页",
			"prev" => "<",
			"next" => ">",
			"list" => "*",
			"jump" => "input" 
	) );
	if (isset ( $tag ['attr_value'] )) {
		$goods = $rs->alias ( "g" )->join ( $join )->field ( $field )->where ( $where )->order ( $order )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
	} else {
		$goods = $rs->alias ( "g" )->field ( $field )->where ( $where )->order ( $order )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
	}
	// echo $rs->getLastSql();
	if( $goods ){
		foreach( $goods as &$val ){
			$val['smallimage'] = getPath( $val['img_url'] );
		}
	}
	$content ['goods'] = $goods;
	$content ['page'] = $Page->show ( 'default' );
	return $content;
}
function getPath( $url ){
	if( $url ){
		if( !strstr('http://', $url ) )
			$url = C('CDN_HOST') . $url;
	}
	else
		$url = '';
	return $url;
}
/**
 *
 * @todo 新品列表查询商品属性
 */
function sp_goods_attr($tag) {
	$where = array ();
	$tag = sp_param_lable ( $tag );
	$field = ! empty ( $tag ['field'] ) ? $tag ['field'] : 'g.*';
	// var_dump($tag);
	if (isset ( $tag ['goods_id'] )) {
		$where ['goods_id'] = array (
				'eq',
				$tag ['goods_id'] 
		);
	}
	if (isset ( $tag ['attr_id'] )) {
		$where ['attr_id'] = array (
				'in',
				$tag ['attr_id'] 
		);
	}
	$rs = M ( 'Goods_attr' )->field ( $field )->where ( $where )->select ();
	$arr = array ();
	if ($rs) {
		foreach ( $rs as $val ) {
			$arr [$val ['attr_id']] = $val ['attr_value'];
		}
	}
	return $arr;
}
/**
 *
 * @todo 排行榜
 */
function sp_goods_sort($tag, $where = array(), $pagesize = 20) {
	$where = array ();
	$tag = sp_param_lable ( $tag );
	// var_dump($tag);
	$field = ! empty ( $tag ['field'] ) ? $tag ['field'] : 'g.*';
	$limit = ! empty ( $tag ['limit'] ) ? $tag ['limit'] : $pagesize;
	$order = ! empty ( $tag ['order'] ) ? $tag ['order'] . ',g.listorder,g.id desc' : 's.this_week,g.listorder,g.id desc';
	
	// 根据参数生成查询条件
	$where ['status'] = array (
			'eq',
			1 
	);
	$where ['isdown'] = array (
			'eq',
			1 
	);
	
	if (isset ( $tag ['cid'] )) {
		$cates = M ( 'Cate' )->field ( 'id,name,parent' )->where ( 'status=1' )->select ();
		// 查询分类下所有子分类
		$ids = getSubCateId ( $cates, $tag ['cid'] );
		if ( $ids ) {
			foreach ( $ids as $v ) {
				$idsSub = getSubCateId ( $cates, $v );
				$ids = array_merge ( $idsSub, $ids );
			}
			$where ['cate_id'] = array ('in',implode ( ',', $ids ));
		} else {
			$where ['cate_id'] = array ('eq', $tag ['cid'] );
		}
	}
	// $join = "".C('DB_PREFIX').'goods_attr as a on g.id = a.goods_id';
	$join1 = "" . C ( 'DB_PREFIX' ) . 'goods_sort as s on g.id = s.goods_id';
	$rs = M ( "Goods" );
	$totalsize = $rs->alias ( "g" )->join ( $join1, 'LEFT' )->field ( $field )->where ( $where )->count ();
	import ( 'Page' );
	if (empty ( $PageParam )) {
		$PageParam = C ( "VAR_PAGE" );
	}
	$Page = new \Page ( $totalsize, $limit );
	$Page->SetPager ( 'default', '<div class="item-page"><ul class="pagination"><li class="prev disabled">{prev}</li><li>{list}</li><li>{next}</li></ul>{jump}</div>', array (
			"listlong" => "6",
			"first" => "首页",
			"last" => "尾页",
			"prev" => "<",
			"next" => ">",
			"list" => "*",
			"jump" => "input" 
	) );
	$goods = $rs->alias ( "g" )->join ( $join1, 'LEFT' )->field ( $field )->where ( $where )->order ( $order )->limit ( $Page->firstRow . ',' . $Page->listRows )->select ();
	// echo $rs->getLastSql();
	if ($goods) {
		foreach ( $goods as &$val ) {
			$val ['smallimage'] = getPath( $val['img_url'] );
		}
	}
	$content ['goods'] = $goods;
	$content ['page'] = $Page->show ( 'default' );
	return $content;
}
/**
 *
 * @todo 根据分类id获取子分类ID
 */
function getSubCateId($cates, $cid) {
	$ids = array ();
	if ($cates && $cid) {
		foreach ( $cates as $val ) {
			if ($val ['parent'] == $cid) {
				$ids [] = $val ['id'];
			}
		}
	}
	return $ids;
}
/**
 *
 * @todo 排行版商品分类
 */
function sp_goods_cate($tag, $where) {
	$where = array ();
	$tag = sp_param_lable ( $tag );
	$field = ! empty ( $tag ['field'] ) ? $tag ['field'] : '*';
	$order = ! empty ( $tag ['order'] ) ? $tag ['order'] : 'listorder, id asc';
	// 根据参数生成查询条件
	$where ['status'] = array (
			'eq',
			1 
	);
	
	$rs = M ( 'Cate' )->field ( $field )->where ( $where )->order ( $order )->select ();
	// echo M('Cate')->getLastSql();
	$arr = array ();
	if ($rs) {
		foreach ( $rs as $val ) {
			if (0 == $val ['parent']) {
				$arr [$val ['id']] = $val;
			}
		}
		foreach ( $rs as $val ) {
			foreach ( $arr as $key => $v ) {
				if ($key == $val ['parent']) {
					$arr [$key] ['sub'] [] = $val;
				}
			}
		}
	}
	return $arr;
}
/**
 * 获得商品的属性和规格
 *
 * @access public
 * @param integer $goods_id        	
 * @return array
 */
function get_goods_properties($goods_id) {
	/* 对属性进行重新排序和分组 */
	$sql = "SELECT attr_group " . "FROM " . C ( 'DB_PREFIX' ) . "type AS gt, " . C ( 'DB_PREFIX' ) . "goods AS g " . "WHERE g.id='$goods_id' AND gt.id=g.type_id";
	$grp = M ()->query ( $sql );
	
	if (! empty ( $grp )) {
		$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
	}
	
	/* 获得商品的规格 */
	$sql = "SELECT a.id, a.name, a.group, a.attr_type, " . "g.id as gid, g.attr_value, g.attr_price " . 'FROM ' . C ( 'DB_PREFIX' ) . 'goods_attr AS g ' . 'LEFT JOIN ' . C ( 'DB_PREFIX' ) . 'type_attr AS a ON a.id = g.attr_id ' . "WHERE g.goods_id = '$goods_id' " . 'ORDER BY a.listorder, g.attr_price, g.id';
	$res = M ()->query ( $sql );
	
	$arr ['pro'] = array (); // 属性
	$arr ['spe'] = array (); // 规格
	
	foreach ( $res as $row ) {
		$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );
		
		if ($row ['attr_type'] == 0) {
			$group = (! empty ( $groups [$row ['group']] )) ? $groups [$row ['group']] : '商品参数';
			
			$arr ['pro'] [$group] [$row ['id']] ['name'] = $row ['name'];
			$arr ['pro'] [$group] [$row ['id']] ['value'] = $row ['attr_value'];
		} else {
			$arr ['spe'] [$row ['id']] ['attr_type'] = $row ['attr_type'];
			$arr ['spe'] [$row ['id']] ['name'] = $row ['name'];
			$arr ['spe'] [$row ['id']] ['values'] [] = array (
					'label' => $row ['attr_value'],
					'price' => $row ['attr_price'],
					'id' => $row ['gid'] 
			);
		}
	}
	
	return $arr;
}
/**
 *
 * @todo 商品观看记录
 * @param int $id
 *        	商品ID
 */
function goodshistory($id) {
	$goods = M ( 'Goods' );
	$goodsResult = $goods->where ( " id = '{$id}' " )->find (); // 【通过传递过来的商品唯一的id号， 查找该商品信息】
	$history = cookie ( 'history' );
	if ($history) {
		$current = unserialize ( $history ); // 【当前已浏览过的商品 二维数组】
		$temp_num = count ( $current ); // 【计算里面记录的浏览过的商品的个数】
		if ($temp_num > 7) { // 【这里只记录最多6个足迹】
			$current = array_reverse ( $current );
			array_pop ( $current ); // 【反转数组后弹出最后一个元素（也就是第一个元素）】
			$current = array_reverse ( $current ); // 【再反转回正确的排序】
			$temp_num = 7;
		}
	}
	if ($history == '') { // 【如果一个商品也没看过则存入】
		
		$current [0] ['id'] = $goodsResult ['id']; // id
		$current [0] ['name'] = $goodsResult ['name'];
		$current [0] ['smallimage'] = getPath( $goodsResult['img_url'] ); // 商品缩略图
		$current [0] ['price'] = $goodsResult ['price']; // 供货价
		
		cookie ( 'history', serialize ( $current ), array (
				'expire' => 3600,
				'path' => '/' 
		) ); // 【thinkphp特有的写cookie的函数方法】
	} else { // 【如果cookie有商品浏览历史记录】
		
		$temp_s = 0; // 【临时变量,否则判断当前商品ID和数组中存的ID是否有一样,一样则$temp_s=1】
		
		foreach ( $current as $key => $value ) {
			foreach ( $current [$key] as $key2 => $value2 ) {
				if ($value2 == $goodsResult ['id']) { // 有本产品的记录则不操作
					$temp_s = 1;
				}
			}
		}
		if ($temp_s == 0) // 【如果没一样的则记录下来】
{
			$current [$temp_num] ['id'] = $goodsResult ['id']; // id
			$current [$temp_num] ['name'] = $goodsResult ['name'];
			$current [$temp_num] ['smallimage'] = getPath( $goodsResult['img_url'] ); // 商品缩略图
			$current [$temp_num] ['price'] = $goodsResult ['price']; // 供货价
			
			cookie ( 'history', serialize ( $current ), array (
					'expire' => 3600,
					'path' => '/' 
			) );
		}
	}
}