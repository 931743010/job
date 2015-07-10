<?php

namespace Goods\Controller;

use Common\Controller\AdminbaseController;

class AdminGoodsController extends AdminbaseController {
	protected $goods_obj;
	function _initialize() {
		parent::_initialize ();
		$this->goods_obj = D ( "Common/Goods" );
	}
	function index($status = 1) {
		if (isset ( $_POST ['intro_type'] ) && '' != $_POST ['intro_type']) {
			if ('all_type' == $_POST ['intro_type'])
				$where_ands = array (
						"status=" . $status . " and isnew=1 and ishot=1 and isprice=1 and isrec=1" 
				);
			else
				$where_ands = array (
						"status=" . $status . " and " . $_POST ['intro_type'] . "=1" 
				);
		} else {
			$where_ands = array (
					"status=" . $status 
			);
		}
		$fields = array (
				'cate_id' => array (
						"field" => "cate_id",
						"operator" => "=" 
				),
				'brand_id' => array (
						"field" => "brand_id",
						"operator" => "=" 
				),
				'keyword' => array (
						"field" => "name",
						"operator" => "like" 
				),
				'supplier_id' => array (
						"field" => "supplier_id",
						"operator" => "=" 
				),
				'isdown' => array (
						"field" => "isdown",
						"operator" => "=" 
				),
				'start_time' => array (
						"field" => "create_date",
						"operator" => ">" 
				),
				'end_time' => array (
						"field" => "create_date",
						"operator" => "<" 
				),
				'keyword' => array (
						"field" => "name",
						"operator" => "like" 
				) 
		);
		if (IS_POST) {
			$_GET ['intro_type'] = $_POST ['intro_type'];
			foreach ( $fields as $param => $val ) {
				if (isset ( $_POST [$param] ) && '' != $_POST [$param]) {
					$operator = $val ['operator'];
					$field = $val ['field'];
					$get = $_POST [$param];
					$_GET [$param] = $get;
					if ($operator == "like") {
						$get = "%$get%";
					}
					array_push ( $where_ands, "$field $operator '$get'" );
				}
			}
		} else {
			foreach ( $fields as $param => $val ) {
				if (isset ( $_GET [$param] ) && ! empty ( $_GET [$param] )) {
					$operator = $val ['operator'];
					$field = $val ['field'];
					$get = $_GET [$param];
					if ($operator == "like") {
						$get = "%$get%";
					}
					array_push ( $where_ands, "$field $operator '$get'" );
				}
			}
		}
		$where = join ( " and ", $where_ands );
		$count = $this->goods_obj->where ( $where )->count ();
		$page = $this->page ( $count, 20 );
		$goods = $this->goods_obj->where ( $where )->limit ( $page->firstRow . ',' . $page->listRows )->order ( 'id desc' )->select ();
		$this->assign ( "Page", $page->show ( 'Admin' ) );
		$this->assign ( "formget", $_GET );
		$this->assign ( "goods", $goods );
		// cate
		$cate = sp_sql_cates ();
		$this->assign ( "cate", $cate );
		// brand
		$brand = sp_sql_brands ();
		$this->assign ( "brand", $brand );
		// supplier
		$supplier = sp_sql_supplier ();
		$this->assign ( "supplier", $supplier );
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->display ();
	}
	function recyclebin() {
		$this->index ( 0 );
	}
	function add() {
		// cate
		$cate = sp_sql_cates ();
		$this->assign ( "cate", $cate );
		// brand
		$brand = sp_sql_brands ();
		$this->assign ( "brand", $brand );
		// type
		$type = sp_sql_types ();
		$this->assign ( "types", $type );
		// supplier
		$supplier = sp_sql_supplier ();
		$this->assign ( "supplier", $supplier );
		// availability
		$availability = sp_sql_availability ();
		$this->assign ( "availability", $availability );
		// format
		$format = sp_sql_format ();
		$this->assign ( "format", $format );
		// charge
		$charge = sp_sql_charge ();
		$this->assign ( "charge", $charge );
		$this->assign ( "goods_attr_html", '' );
		$this->display ();
	}
	function add_post() {
		if (IS_POST) {
			$page = I ( "post.post" );
			// goods serial
			$page ['serial'] = sp_sql_goods_serial ( $page ['serial'] );
			if (false === $page ['serial']) {
				$this->error ( "您输入的商品货号已存在，请换一个！" );
			}
			$page ['content'] = htmlspecialchars_decode ( $page ['content'] );
			// 处理图片
			$isIndex = I ( 'post.goods_photos_isIndex' );
			$gid = I ( 'post.gid' );
			$photos_url = I ( 'post.goods_photos_url' );
			if ($gid) {
				foreach ( $gid as $key => $val ) {
					if ($isIndex == $gid [$key]) {
						$page ['img_url'] = $photos_url [$key];
						break;
					}
				}
			}
			if ($this->goods_obj->create ( $page )) {
				$result = $this->goods_obj->add ();
			}
			if ($result) {
				// goods gallery
				$photos_alt = I ( 'post.goods_photos_alt' );
				if ($photos_url) {
					$model = M ( "Goods_gallery" );
					foreach ( $photos_url as $key => $val ) {
						$data = array ();
						$data ['pid'] = $result;
						$data ['img_original'] = $val;
						$data ['img_url'] = $val;
						$data ['thumb_url'] = sp_asset_url ( $val );
						$data ['img_desc'] = $photos_alt [$key];
						if ($model->create ( $data )) {
							$model->add ();
						} else {
							$this->error ( $this->dao->getError () );
						}
					}
				}
				// goods type attr
				$keyword = $this->setGoodsAttr( $result, $page[type_id] );
				// search
				$data = array();
				$data['name'] = $page['name']; // 商品名称
				$data['title'] = $page['title'];
				$data['price'] = $page['price']; // 价格
				$data['content'] = $page['content']; // 简介
				$data['img_url'] = $page['img_url']; // 原图
				$data['format'] = $page['format']; // 格式
				$data['keyword'] = $keyword; // keyword
				$data['cate_id'] = $page['cate_id']; // 類別
				$data['released'] = I('post.attr_value_24'); // 出版年份
				$data['availability'] = $page['availability']; // 貨品付運預計時間
				$data['status'] = 1;                    // 正常
				$data['isdown'] = $page['isdown'];      // 上架
				$data['preorder'] = $page['preorder'];  // 预购
				$data['sales'] = 0;   // 销量
				$data['comment'] = 0; // 好评
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->create($result, $data);
				$this->success ( "添加成功！" );
			} else {
				$this->error ( "添加失败！" );
			}
		}
	}
	public function edit() {
		// cate
		$cate = sp_sql_cates ();
		$this->assign ( "cate", $cate );
		// brand
		$brand = sp_sql_brands ();
		$this->assign ( "brand", $brand );
		// type
		$type = sp_sql_types ();
		$this->assign ( "type", $type );
		// supplier
		$supplier = sp_sql_supplier ();
		$this->assign ( "supplier", $supplier );
		// availability
		$availability = sp_sql_availability ();
		$this->assign ( "availability", $availability );
		// format
		$format = sp_sql_format ();
		$this->assign ( "format", $format );
		// charge
		$charge = sp_sql_charge ();
		$this->assign ( "charge", $charge );
		$id = intval ( I ( "get.id" ) );
		$goods = $this->goods_obj->where ( "id=$id" )->find ();
		$this->assign ( "goods", $goods );
		// 商品相册
		$list = sp_sql_gallery ( $id );
		$this->assign ( "gallery", $list );
		// 商品关联
		$list = sp_sql_link_goods ( $id );
		$this->assign ( "link_goods", $list );
		// 文章关联
		$list = sp_sql_link_posts ( $id );
		$this->assign ( "link_posts", $list );
		
		$this->assign ( "goods_attr_html",  $this->build_attr_html( $goods['type_id'], $id ) );
		$this->display ();
	}
	public function edit_post() {
		if (IS_POST) {
			$page = I ( "post.post" );
			$page ['serial'] = sp_sql_goods_serial ( $page ['serial'], $page ['id'] );
			if (false === $page ['serial']) {
				$this->error ( "您输入的商品货号已存在，请换一个！" );
			}
			$page ['content'] = htmlspecialchars_decode ( $page ['content'] );
			// 处理图片
			$isIndex = I ( 'post.goods_photos_isIndex' );
			$gid = I ( 'post.gid' );
			$photos_url = I ( 'post.goods_photos_url' );
			if ($gid) {
				foreach ( $gid as $key => $val ) {
					if ($isIndex == $gid [$key]) {
						$page ['img_url'] = $photos_url [$key];
						break;
					}
				}
			}
			if ($this->goods_obj->create ( $page )) {
				$result = $this->goods_obj->save ();
			}
			// if ($result) {
			// goods gallery
			$model = M ( "Goods_gallery" );
			// 查询已存在数据
			$list = $model->field ( 'id,img_url' )->where ( 'pid=' . $page ['id'] )->select ();
			if ($list) {
				foreach ( $list as $v ) {
					$idsTmp [] = $v ['id'];
					$imgUrl [$v ['id']] = $v ['img_url'];
				}
				if ($gid) { // 判断是否有删除数据
					$arr = array_diff ( $idsTmp, $gid );
					if ($arr) {
						foreach ( $arr as $val ) {
							$file = './' . $imgUrl [$val];
							if (file_exists ( $file )) {
								unlink ( $file );
							}
						}
					}
				} else {
					$idsDel = $idsTmp;
					foreach ( $idsTmp as $v ) {
						$file = './' . $imgUrl [$v];
						if (file_exists ( $file )) {
							unlink ( $file );
						}
					}
				}
			}
			if ($idsDel) {
				$map = array ();
				$map ['pid'] = array (
						'eq',
						$page ['id'] 
				);
				$map ['id'] = array (
						'in',
						$idsDel 
				);
				$model->where ( $map )->delete ();
			}
			$photos_alt = I ( 'post.goods_photos_alt' );
			$photos_listorder = I ( 'post.goods_photos_listorder' );
			if ($photos_url) {
				foreach ( $photos_url as $key => $val ) {
					$data = array ();
					$data ['pid'] = $page ['id'];
					$data ['img_original'] = $val;
					$data ['img_url'] = $val;
					$data ['thumb_url'] = sp_asset_url ( $val );
					$data ['img_desc'] = $photos_alt [$key];
					$data ['listorder'] = $photos_listorder [$key];
					if ($gid [$key] && 'randid_' != substr ( $gid [$key], 0, 7 )) { // update
						$data ['id'] = $gid [$key];
						$model->save ( $data );
					} else { // add
					         // var_dump($data);die();
						if ($model->create ( $data )) {
							$model->add ();
						} else {
							$this->error ( $model->getError () );
						}
					}
				}
			}
			// goods type attr
			$keyword = $this->setGoodsAttr( $page ['id'], $page[type_id] );
			$ret = true;
			if ($ret) {
				$row = M('Goods_sort')->field('total,comment')->where('goods_id=' . $page['id'] )->find();
				$data = array();
				$data['name'] = $page['name']; // 商品名称
				$data['title'] = $page['title'];
				$data['price'] = $page['price']; // 价格
				$data['content'] = $page['content']; // 简介
				$data['img_url'] = $page['img_url']; // 原图
				$data['format'] = $page['format'];  // 格式
				$data['keyword'] = $keyword;
				$data['cate_id'] = $page['cate_id']; // 類別
				$data['released'] = 1985; // 出版年份
				$data['availability'] = $page['availability']; // 貨品付運預計時間
				$data['status'] = $page['status'];      // 停售
				$data['isdown'] = $page['isdown'];      // 上架
				$data['preorder'] = $page['preorder'];  // 预购
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->update($page ['id'], $data);
				//var_dump($data);die();
				$this->success ( "保存成功！" );
			} else {
				$this->error ( "保存失败！" );
			}
		}
	}
	function delete() {
		if (isset ( $_POST ['ids'] )) {
			$ids = implode ( ",", $_POST ['ids'] );
			$data = array (
					"status" => "0" 
			);
			if ($this->goods_obj->where ( "id in ($ids)" )->save ( $data )) {
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->updates( $_POST ['ids'], $data );
				$this->success ( "删除成功！" );
			} else {
				$this->error ( "删除失败！" );
			}
		} else {
			if (isset ( $_GET ['id'] )) {
				$id = intval ( I ( "get.id" ) );
				$data = array (
						"id" => $id,
						"status" => "0" 
				);
				if ($this->goods_obj->save ( $data )) {
					include('ec_goods.class.php');
					$ec_goods = new \ec_goods();
					$data = array (
							"status" => "0"
					);
					$ec_goods->update( $id, $data );
					$this->success ( "删除成功！" );
				} else {
					$this->error ( "删除失败！" );
				}
			}
		}
	}
	function restore() {
		if (isset ( $_POST ['ids'] )) {
			$ids = implode ( ",", $_POST ['ids'] );
			$data = array (
					"status" => "1" 
			);
			if ($this->goods_obj->where ( "id in ($ids)" )->save ( $data ) !== false) {
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->updates( $_POST ['ids'], $data );
				$this->success ( "还原成功！" );
			} else {
				$this->error ( "还原失败！" );
			}
		}
		if (isset ( $_GET ['id'] )) {
			$id = intval ( I ( "get.id" ) );
			$data = array (
					"id" => $id,
					"status" => "1" 
			);
			if ($this->goods_obj->save ( $data )) {
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$data = array (
						"status" => "1"
				);
				$ec_goods->update( $id, $data );
				$this->success ( "还原成功！" );
			} else {
				$this->error ( "还原失败！" );
			}
		}
	}
	function clean() {
		if (isset ( $_POST ['ids'] )) {
			$ids = implode ( ",", $_POST ['ids'] );
			if ($this->goods_obj->where ( "id in ($ids)" )->delete () !== false) {
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->deletes( $_POST ['ids']  );
				$this->success ( "删除成功！" );
			} else {
				$this->error ( "删除失败！" );
			}
		}
		if (isset ( $_GET ['id'] )) {
			$id = intval ( I ( "get.id" ) );
			if ($this->goods_obj->delete ( $id ) !== false) {
				include('ec_goods.class.php');
				$ec_goods = new \ec_goods();
				$ec_goods->delete( $_GET ['id'] );
				$this->success ( "删除成功！" );
			} else {
				$this->error ( "删除失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 商品类型属性
	 */
	function getGoodsTypeAttrs() {
		$type_id = I ( "get.type_id" );
		$goods_id = I ( "get.goods_id" );
		$content = $this->build_attr_html( $type_id, $goods_id );
		$data ['status'] = 1;
		$data ['content'] = $content;
		$this->ajaxReturn ( $data );
	}
	/**
	 *
	 * @todo 获取商品名称和ID
	 */
	function search_goods() {
		$map ['status'] = array (
				'gt',
				0 
		);
		$goods_id = I ( 'get.goods_id' );
		$map ['id'] = array (
				'neq',
				$goods_id 
		);
		$cate_id = I ( 'get.cate_id' );
		$brand_id = I ( 'get.brand_id' );
		$keyword = I ( 'get.keyword' );
		if ($cate_id)
			$map ['cate_id'] = array (
					'eq',
					$cate_id 
			);
		if ($brand_id)
			$map ['brand_id'] = array (
					'eq',
					$brand_id 
			);
		if ($keyword)
			$map ['name'] = array (
					'like',
					'%' . $keyword . '%' 
			);
		$list = $this->goods_obj->field ( 'id,name' )->where ( $map )->order ( 'id desc' )->select ();
		$optionHtml = array_select ( $list );
		$data ['status'] = 1;
		$data ['content'] = $optionHtml;
		$this->ajaxReturn ( $data );
	}
	/**
	 *
	 * @todo 获取文章名称和ID
	 */
	function search_posts() {
		$map ['post_status'] = array (
				'gt',
				0 
		);
		$keyword = I ( 'get.keyword' );
		if ($keyword)
			$map ['post_title'] = array (
					'like',
					'%' . $keyword . '%' 
			);
		$list = M ( 'Posts' )->field ( 'id,post_title' )->where ( $map )->order ( 'id desc' )->select ();
		$optionHtml = array_select ( $list, 'source_name_posts', 'id', 'post_title' );
		$data ['status'] = 1;
		$data ['content'] = $optionHtml;
		$this->ajaxReturn ( $data );
	}
	/**
	 *
	 * @todo 关联商品
	 */
	function add_link_goods() {
		$act = I ( 'get.act' );
		$is_single = I ( 'get.is_single' );
		$ids = I ( 'get.ids' );
		$goods_id = I ( 'get.goods_id' );
		if ($ids) {
			$is_double = 1;
			if (1 == $is_single)
				$is_double = 0;
			$linkGoodModel = M ( 'Link_goods' );
			if ('clean' == $act) { // 全选清空
				$linkGoodModel->where ( 'goods_id=' . $goods_id )->delete ();
			}
			foreach ( $ids as $id ) {
				$dataList [] = array (
						'goods_id' => $goods_id,
						'is_double' => $is_double,
						'link_goods_id' => $id,
						'admin_id' => $_SESSION ['ADMIN_ID'] 
				);
			}
			$ret = $linkGoodModel->addAll ( $dataList );
			if ($ret) {
				$this->success ( "关联成功！" );
			} else {
				$this->error ( "关联失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 取消商品关联
	 */
	function drop_link_goods() {
		$ids = I ( 'get.ids' );
		$goods_id = I ( 'get.goods_id' );
		if ($ids) {
			$map = array ();
			$map ['goods_id'] = array (
					'eq',
					$goods_id 
			);
			$map ['link_goods_id'] = array (
					'in',
					$ids 
			);
			$ret = M ( 'Link_goods' )->where ( $map )->delete ();
			if ($ret) {
				$this->success ( "取消关联成功！" );
			} else {
				$this->error ( "取消关联失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 关联文章
	 */
	function add_link_posts() {
		$act = I ( 'get.act' );
		$ids = I ( 'get.ids' );
		$goods_id = I ( 'get.goods_id' );
		if ($ids) {
			$linkPostsModel = M ( 'Link_posts' );
			if ('clean' == $act) { // 全选清空
				$linkPostsModel->where ( 'goods_id=' . $goods_id )->delete ();
			}
			foreach ( $ids as $id ) {
				$dataList [] = array (
						'goods_id' => $goods_id,
						'posts_id' => $id,
						'admin_id' => $_SESSION ['ADMIN_ID'] 
				);
			}
			$ret = $linkPostsModel->addAll ( $dataList );
			if ($ret) {
				$this->success ( "关联成功！" );
			} else {
				$this->error ( "关联失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 取消文章关联
	 */
	function drop_link_posts() {
		$ids = I ( 'get.ids' );
		$goods_id = I ( 'get.goods_id' );
		if ($ids) {
			$map = array ();
			$map ['goods_id'] = array (
					'eq',
					$goods_id 
			);
			$map ['posts_id'] = array (
					'in',
					$ids 
			);
			$ret = M ( 'Link_posts' )->where ( $map )->delete ();
			if ($ret) {
				$this->success ( "取消关联成功！" );
			} else {
				$this->error ( "取消关联失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 移动商品至分类
	 */
	function move_to_cate() {
		if (isset ( $_POST ['ids'] )) {
			$cate_id = I ( 'post.move_cate_id' );
			if (! $cate_id)
				$this->error ( "请选择商品分类！" );
			$data ['cate_id'] = $cate_id;
			$ids = join ( ",", $_POST ['ids'] );
			if ($this->goods_obj->where ( "id in ($ids)" )->save ( $data ) !== false) {
				$this->success ( "设置成功！" );
			} else {
				$this->error ( "设置失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 移动商品至供应商
	 */
	function move_to_supplier() {
		if (isset ( $_POST ['ids'] )) {
			$supplier_id = I ( 'post.move_supplier_id' );
			if (! $supplier_id)
				$this->error ( "请选择供应商！" );
			$data ['supplier_id'] = $supplier_id;
			$ids = join ( ",", $_POST ['ids'] );
			if ($this->goods_obj->where ( "id in ($ids)" )->save ( $data ) !== false) {
				$this->success ( "设置成功！" );
			} else {
				$this->error ( "设置失败！" );
			}
		}
	}
	/**
	 *
	 * @todo 写入商品信息
	 */
	function setElasticsearch( $id, $data ) {
		if ($data) {
			$client = elasticsearch();
			$params = array();
			$params['body']  = $data;
			$params['index'] = 'ec_' . C('DB_NAME');
			$params['type']  = 'ec_goods';
			$params['id']    = $id;
			$ret = $client->index( $params );
		}
	}
	/**
	 * 根据属性数组创建属性的表单
	 *
	 * @access  public
	 * @param   int     $cat_id     分类编号
	 * @param   int     $goods_id   商品编号
	 * @return  string
	 */
	function build_attr_html($cat_id, $goods_id = 0)
	{
		$attr = $this->get_attr_list($cat_id, $goods_id);
		$html = '<table width="100%" id="attrTable">';
		$spec = 0;
	
		foreach ($attr AS $key => $val)
		{
			$html .= "<tr><td width='80' height='35'>";
			if ($val['attr_type'] == 1 || $val['attr_type'] == 2)
			{
				$html .= ($spec != $val['id']) ?
				"<a href='javascript:;' onclick='addSpec(this)'>[+]</a>" :
				"<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
				$spec = $val['id'];
			}
	
			$html .= "$val[name]</td><td><input type='hidden' name='attr_id_list[]' value='$val[id]' />";
	
			if ($val['input_type'] == 0)
			{
				$html .= '<input name="attr_value_list[]" type="text" value="' .htmlspecialchars($val['attr_value']). '" size="40" /> ';
			}
			elseif ($val['input_type'] == 2)
			{
				$html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' .htmlspecialchars($val['attr_value']). '</textarea>';
			}
			else
			{
				$html .= '<select name="attr_value_list[]">';
				$html .= '<option value="">请选择</option>';
	
				$attr_values = explode("\n", $val['values']);
	
				foreach ($attr_values AS $opt)
				{
					$opt    = trim(htmlspecialchars($opt));
	
					$html   .= ($val['attr_value'] != $opt) ?
					'<option value="' . $opt . '">' . $opt . '</option>' :
					'<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
				}
				$html .= '</select> ';
			}
	
			$html .= ($val['attr_type'] == 1 || $val['attr_type'] == 2) ?
			'属性价格 <input type="text" name="attr_price_list[]" value="' . $val['attr_price'] . '" size="5" maxlength="10" />' :
			' <input type="hidden" name="attr_price_list[]" value="0" />';
	
			$html .= '</td></tr>';
		}
	
		$html .= '</table>';
	
		return $html;
	}
	/**
	 * 取得通用属性和某分类的属性，以及某商品的属性值
	 * @param   int     $cat_id     分类编号
	 * @param   int     $goods_id   商品编号
	 * @return  array   规格与属性列表
	 */
	function get_attr_list($cat_id, $goods_id = 0)
	{
		if (empty($cat_id))
		{
			return array();
		}
	
		// 查询属性值及商品的属性值
		$sql = "SELECT a.id, a.name, a.input_type, a.attr_type, a.values, v.attr_value, v.attr_price ".
				"FROM " . C('DB_PREFIX') . "type_attr AS a ".
				"LEFT JOIN " . C('DB_PREFIX') . "goods_attr AS v ".
				"ON v.attr_id = a.id AND v.goods_id = '$goods_id' ".
				"WHERE a.type_id = " . intval($cat_id) ." OR a.type_id = 0 ".
				"ORDER BY a.listorder, a.attr_type, a.id, v.attr_price, v.attr_id";
		$row = M()->query( $sql );	
		return $row;
	}
	/**
	 * @todo 属性处理
	 */
	function setGoodsAttr( $goods_id, $type_id ){
		/* 处理属性 */
		if ((isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) || (empty($_POST['attr_id_list']) && empty($_POST['attr_value_list'])))
		{
			// 取得原有的属性值
			$goods_attr_list = array();
		
			$keywords_arr = explode(" ", $_POST['keywords']);
		
			$keywords_arr = array_flip($keywords_arr);
			if (isset($keywords_arr['']))
			{
				unset($keywords_arr['']);
			}		
			$sql = "SELECT id, attr_index FROM " .  C('DB_PREFIX') . "type_attr WHERE type_id = '" . $type_id . "'";
			$attr_res = M()->query($sql);		
			$attr_list = array();		
			if( $attr_res ){
				foreach( $attr_res as $row )
				{
					$attr_list[$row['id']] = $row['attr_index'];
				}
			}		
			$sql = "SELECT g.*, a.attr_type
                FROM " . C('DB_PREFIX') . "goods_attr AS g
                    LEFT JOIN " .  C('DB_PREFIX') . "type_attr AS a
		                    ON a.id = g.attr_id
		                    WHERE g.goods_id = '$goods_id'";
			$res = M()->query($sql);		
			if( $res ){
				foreach( $res as $row )
				{
					$goods_attr_list[$row['attr_id']][$row['attr_value']] = array('sign' => 'delete', 'goods_attr_id' => $row['attr_id']);
				}
			}
			// 循环现有的，根据原有的做相应处理
			if(isset($_POST['attr_id_list']))
			{
				foreach ($_POST['attr_id_list'] AS $key => $attr_id)
				{
					$attr_value = $_POST['attr_value_list'][$key];
					$attr_price = $_POST['attr_price_list'][$key];
					if (!empty($attr_value))
					{
						if (isset($goods_attr_list[$attr_id][$attr_value]))
						{
							// 如果原来有，标记为更新
							$goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
							$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
						}
						else
						{
							// 如果原来没有，标记为新增
							$goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
							$goods_attr_list[$attr_id][$attr_value]['attr_price'] = $attr_price;
						}
						$val_arr = explode(' ', $attr_value);
						foreach ($val_arr AS $k => $v)
						{
							if (!isset($keywords_arr[$v]) && $attr_list[$attr_id] == "1")
							{
								$keywords_arr[$v] = $v;
							}
						}
					}
				}
			}
			$keywords = join(' ', array_flip($keywords_arr));
		
			$sql = "UPDATE " . C('DB_PREFIX') . "goods SET keywords = '$keywords' WHERE id = '$goods_id' LIMIT 1";
			M()->execute( $sql );
			/* 插入、更新、删除数据 */
			foreach ($goods_attr_list as $attr_id => $attr_value_list)
			{
				foreach ($attr_value_list as $attr_value => $info)
				{
					if ($info['sign'] == 'insert')
					{
						$sql = "INSERT INTO " . C('DB_PREFIX') . "goods_attr (attr_id, goods_id, attr_value, attr_price)".
								"VALUES ('$attr_id', '$goods_id', '$attr_value', '$info[attr_price]')";
					}
					elseif ($info['sign'] == 'update')
					{
						$sql = "UPDATE " . C('DB_PREFIX') . "goods_attr SET attr_price = '$info[attr_price]' WHERE attr_id = '$info[goods_attr_id]' LIMIT 1";
					}
					else
					{
						$sql = "DELETE FROM " . C('DB_PREFIX') . "goods_attr WHERE attr_id = '$info[goods_attr_id]' LIMIT 1";
					}
					M()->execute( $sql );
				}
			}
		}
		return $keywords;
	}
}