<?php

/**
 * 商品
 */
namespace Goods\Controller;
use Common\Controller\HomeBaseController;
class IndexController extends HomeBaseController {
	private $objOrder;
	private $goods_obj;
	private $user;
	public function _initialize(){
		parent::_initialize();
		$this->objOrder = D("Common/Order");
		$this->goods_obj = M('Goods');
	}
	public function index(){
		$cate = I('get.cate');
		$this->assign ( "cid", I('get.cid') );
		$this->assign ( "cate", $cate );
		$this->display( $cate );
	}
	public function detail(){
		$id = I('get.id');
		if( !$id ) $this->error('不存在的商品');
		$detail = $this->goods_obj->where( array('id'=>$id,'is_down'=>0) )->find();
		if( !is_array($detail) ) $this->error('商品不存在或已下架！');
		if( $detail['img_url'] )
			$detail['img_url'] = getPath( $detail['img_url'] );
		$this->assign('detail' , $detail);
		// 观看记录
		goodshistory( $id );
		$this->assign('history', unserialize(cookie ( 'history')) ); // 观看记录
		// 商品图片
		$gallery = M('Goods_gallery')->where(array('pid'=>$id))->select();
		if( $gallery ){
			foreach( $gallery as &$val ){
				$val['img_url'] = getPath( $val['img_url'] );
				$val['thumb_url'] = getPath( $val['thumb_url'] );
			}
		}
		//var_dump($gallery);die();
		$this->assign('pics' , $gallery );
		// format
		$format = sp_sql_format ();
		$this->assign ( "format", $format[ $detail['format'] ]);
		// charge
		$charge = sp_sql_charge ();
		$this->assign ( "charge", $charge[ $detail['charge'] ]);
		// 猜你喜欢 - 读取关联商品
		$ids = M('Link_goods')->field('link_goods_id')->where('goods_id=' . $id )->limit(4)->select();
		$recGoods = array();
		$recGoods_link = array();
		if( $ids ){
			foreach( $ids as $v ){
				$id_arr[] = $v['link_goods_id'];
			}
			if( $id_arr ){
				$map = array();
				$map['id'] = array( 'in', $id_arr );
				$recGoods_link = $this->goods_obj->field('id,name,img_url,price')->where( $map )->limit(4)->select();
			}
		}
		// 推荐商品
		$map = array();
		$map['isrec'] = array('eq', 1);
		$recGoods = $this->goods_obj->field('id,name,img_url,price')->where( $map )->limit(3)->select();
		
		$properties = get_goods_properties( $id );  // 获得商品的规格和属性
		// 商品评价
		$comments = M('comments_goods')->field('id,uid,img_url,thumb_url,content,type,createtime,username,order_id')->where('goods_id = '. $id)->select();
		$comments_all = array();
		if( !empty($comments) ){
			foreach( $comments as $v ){		
				if( !empty($v['img_url']) ){
					$v['img_url'] = explode('|', $v['img_url']);
					$v['thumb_url'] = explode('|', $v['thumb_url']);
					foreach ($v['img_url'] as $k => $val){
						$v['img'][$k]['big'] = $val;
						$v['img'][$k]['small'] = $v['thumb_url'][$k];
					}
				}
				$len = strlen($v['username'])/3;
    			$v['username'] = substr_replace($v['username'],str_repeat('*',$len),ceil(($len)/2)+2,$len);
				$comments_all[$v['order_id']][] = $v;
			}
		}
		$comments_all = array_reverse($comments_all);
		$this->assign('comments_all', $comments_all);  // 商品评价
        $this->assign('properties', $properties['pro']);  // 商品属性
        $this->assign('specification', $properties['spe']);   
		
		$this->assign ( "recGoods", $recGoods );
		$this->assign ( "recGoods_link", $recGoods_link );
		$this->display();
	}
	
	private function ifLogin(){
		if( !$_SESSION['user']['id'] ) $this->error('请您先去登陆,3秒后自动跳转登陆页面',U('User/login/index'));
		$this->user = $_SESSION['user'];
	}
	public function sort(){
		$cid = !empty( I('get.cid') ) ? I('get.cid') : 24;
		$this->assign ( "cid", $cid );
		$this->assign ( "p", !empty( I('get.p')) ? I('get.p') : 1 );
		$this->assign ( "pid", I('get.pid') );
		$this->assign ( "type", I('get.type') );
		$this->display();
	}
	/**
	 * 根据属性改变商品价格
	 */
	function getPrice(){
		$attr_id    = isset($_REQUEST['attr']) ? explode(',', $_REQUEST['attr']) : array();
		$number     = (isset($_REQUEST['number'])) ? intval($_REQUEST['number']) : 1;
		$goods_id     = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;
	
		if ($goods_id == 0)
		{
			$this->error ( "商品ID不能为空！" );
		}
		else
		{
			if ($number == 0)
			{
				$res['qty'] = $number = 1;
			}
			else
			{
				$res['qty'] = $number;
			}
	
			$shop_price  = get_final_price($goods_id, $number, true, $attr_id);
			$res['result'] = price_format($shop_price * $number);
		}
	
		die($json->encode($res));
	}
	/**
	 * @todo 首页商品排行分类
	 */
	function getCate(){
		$cate = sp_sql_cate( 24 );
		$goods = $this->getGoodsSort( $cate[0]['id'] );
		$cateHtml = '';
		if( $cate ){
			foreach( $cate as $key=>$val ){
				$class = '';
				if( 0 == $key )
					$class = 'class="active"';
				$cateHtml .= '<a ' . $class . ' href="javascript:getGoods(' . $val['id'] . ')">' . $val['name'] . '</a>';
				if( 6 == $key )
					break;
			}
		}
		$ret['cateHtml'] = $cateHtml;
		$ret['goodsHtml'] = $goods;
		$this->success( $ret );
	}
	/**
	 * @todo 根据分类Id获取商品排行
	 */
	function getGoodsSort( $id = '' ){
		if( !$id )
			$cid = I( 'get.cid' ); 
		else 
			$cid = $id;
		$where['cate_id'] = array('eq', $cid ); 
		$where['status'] = array('eq', 1 );
		$where['isdown'] = array('eq', 1 );
		$join1 = "" . C ( 'DB_PREFIX' ) . 'goods_sort as s on g.id = s.goods_id';
		$rs = M ( "Goods" );
		$goods = $rs->alias ( "g" )->join ( $join1, 'LEFT' )->field ( 'g.id,g.name,g.title,g.price,g.pricespe,g.img_url,s.this_week,s.last_week' )->where ( $where )->order ( 's.this_week' )->limit ( 4 )->select ();
		// echo $rs->getLastSql();
		$goodsHtml = '';
		if ($goods) {
			foreach ( $goods as $key=>$val ) {
				$class = '';
				if( 3 == $key )
					$class = ' group-nmar';
				$price = $val['pricespe'] > 0 ? $val['pricespe'] : $val['price'];
				$goodsHtml .= '<li class="group-1 text-overflow ' . $class . '">';
				$goodsHtml .= '<i class="list-icon">' . ($key + 1) . '</i><h5>';
				$goodsHtml .= '<a href="">' . $val['name'] . '</a>';
			 	$goodsHtml .= '<p class="tips">' . $val['title'] . '</p></h5>';
				$goodsHtml .= '<a href=""><img src="' . getPath( $val['img_url'] ) . '"/></a>';
				$goodsHtml .= '<div class="intr">';
				$goodsHtml .= '<span class="price">HK$' . $price . '</span>';
				if( $val['this_week'] > $val['last_week'] && $val['last_week'] != 0 )
					$sort = '↑';
				else if( $val['this_week'] < $val['last_week'] && $val['last_week'] != 0  )
					$sort = '↓';
				else if( $val['this_week'] == $val['last_week'] && $val['last_week'] != 0  )
					$sort = '-';
				else 
					$sort = '新上榜';
				$goodsHtml .= '<span class="sort">排名：' . $sort . '</span>';
				$goodsHtml .= '</div></li>';								
			}
		}
		if( $id )
			return $goodsHtml;
		else
			$this->success( $goodsHtml );
	}

}
