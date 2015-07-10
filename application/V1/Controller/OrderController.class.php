<?php
/*
@author liufee
@email job@feehi.com
@description api of orders
@date 2015-05-14
**/
namespace V1\Controller;
Class OrderController extends PublicRestController {
    protected $allowMethod    = array('get','post','put','delete'); // REST允许的请求类型列表
    protected $allowType      = array('html','json','xml'); // REST允许请求的资源类型列表
    
    Public function read_get_html(){
       $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr);
    }
    Public function read_get_xml(){
       	$arr = array("name"=>'Foxcon', 'age'=>'12q');
       	$this->response($arr, 'xml');
    }
    Public function read_xml(){
        $arr = array("name"=>'Foxcon', 'age'=>'12');
        $this->response($arr, 'xml');
    }
	
	/**
	@description     according order id or user id to supply the order(s) details
	@param int uid   user id,alternative uid or order id
	@param int id    order_id,alternative uid or order id
	@param int pagesize returned rows,optional parameters default 10
	@param int p current page,,optional parameters default 1
	*/
    Public function read_json(){    
    	$where = array();
    	$model = M('Order');
    	$id = I('get.id');
		$uid = I('get.uid');
		if( !$id && !uid )  $this->response( array('info'=>C('errorcode.2001') , 'code'=>3001), 'json' );
    	$pagesize = I('get.pagesize');
		if( $id )
			$where['order_id'] = $id;
		else if( $uid ){
			$where['user_id'] = $uid;
			$pagesize = I('get.pagesize');
			$pagesize = $pagesize ? $pagesize : 10; //如果未传入pagesize参数,默认显示10条(备注:可能会使用C方法包含配置中的默认值)
		}
		$count = $model->where($where)->count();
		$page = $this->page( $count, $pagesize  );
		$order = $model->where( $where )->field( $filed )->limit( $page->firstRow . ',' . $page->listRows )->select();
		$data = array(
				'data' => $order,
				'code' => 3000
		);
        $this->response( $data, 'json' );
    }
	
	/**
	@description     writing carts to order
	*/
	public function read_post(){
		$where = array();
		$post = json_decode( $_POST['value'] , true );
		$ids = '';
		foreach($post['goods'] as $k => $v){
			if( $k==0 ){
				$ids = $v['id'];
			}else{
				$ids .= ','.$v['id'];
			}
		};
		if( !$post['uid'] || !$post['country'] || !$post['address'] || !$post['consignee'] ) $this->response( array('info' => C('errorcode.3009') , 'code' => 3009), 'json' );
		$payment = getPaymentMethod($post['pay_id']);
		if( !is_array($payment) ) $this->response( array('info' => C('errorcode.3003') , 'code' => 3003), 'json' );
		$where['id'] = array('in' , $ids);
        $goods_none_order = M('Goods')->where($where)->select();
		$goods = array();
		foreach( $post['goods'] as $k => $v ){
			foreach( $goods_none_order as $key => $val ){
				if( $val['id'] == $v['id'] ){
					$goods[] = $val;
					continue;
				}
			}
		}
		$weight = 0;
		$goods_money = 0;
		foreach( $goods as $key => $value){
			$weight += $value['weight']*$post['goods'][$key]['num'];
			$goods_money += ( $value['pricespe'] ? $value['pricespe'] : $value['price'] ) * $post['goods'][$key]['num'];
		};
		$shipping = getShippingFee( $post['country'] , $post['province'] , $post['city'] , $weight , $post['shipping_id'] );
		if( !is_array( $shipping ) ) $this->response( array( 'info' => C('errorcode.3006') , 'code' => 3006 ), 'json' );
		$insure_fee = 0;
		if( $post['is_insure'] == 1 )
			$insure_fee = $shipping['insure_fee'];
		else
			$post['is_insure'] = 0;
		if( $goods_money > $shipping['free_money'] ) $shipping['shipping_fee'] = 0;//商品价格达到免运费额度
		$shipping_method = getExpressMethod($post['shipping_id']);
		$data = array(
			'order_sn' => date('Ymdhis').substr(microtime(true) , -3),
			'user_id' => $post['uid'],
			'order_status' => 0,
			'shipping_status' => 0,
			'pay_status' => 0,
			'country' => $post['country'],
			'province' => $post['province'],
			'city' => $post['city'],
			'district' => $post['district'],
			'address' => $post['address'],
			'consignee' => $post['consignee'],
			'pay_id' => $post['pay_id'],
			'pay_name' => $payment['title'],
			'paid_money' => 0,
			'pay_fee' => $payment['pay_fee'],
			'shipping_fee' => $shipping['shipping_fee'],
			'insure_fee' => $insure_fee,
			//'package_fee' => $post['package_fee'],
			//'card_fee' => $post['card_fee'],
			//'discount' => $post['discount'],
			//'package_id' => $post['package_id'],
			//'package_name' => $post['packaeg_name'],
			'add_time' => time(),
			'pay_time' => 0,
			'shipping_id' => $post['shipping_id'],
			'shipping_name' => $shipping_method['name'],
			'shipping_sn' => '',
			'shipping_time' => 0,
			//'card_id' => $post['card_id'],
			//'card_name' => $post['card_name'],
			//'card_message' => $post['card_message'],
			'is_insure' => $post['is_insure'],
			'weight' => $weight,
		);
		if( $post['best_time'] ) $data['best_time'] = $post['best_time'];
		if( $post['zipcode'] ) $data['zipcode'] = $post['zipcode'];
		if( $post['tel'] ) $data['tel'] = $post['tel'];
		if( $post['mobile'] ) $data['mobile'] = $post['mobile'];
		if( $post['email'] ) $data['email'] = $post['email'];
		if( $post['receipt_fee'] ) $data['receipt_fee'] = $post['receipt_fee'];
		if( $post['receipt_type'] ) $data['receipt_type'] = $post['receipt_type'];
		if( $post['receipt_head'] ) $data['receipt_head'] = $post['receipt_head'];
		if( $post['receipt_content'] ) $data['receipt_content'] = $post['receipt_content'];
		if( $post['message'] ) $data['message'] = $post['message'];
		if( $post['how_oos'] ) $data['how_oos'] = $post['how_oos'];
		if( $post['pack_id'] ){
			$data['pack_id'] = $post['pack_id'];
			$data['pack_name'] = C('PACKAGE')[$post['pack_id']]['name'];
			$data['pack_fee'] = C('PACKAGE')[$post['pack_id']]['fee'];
		}
		if( $post['ref'] ) $data['ref'] = $post['ref'];
		if( $ids ) 
			$where['id'] = array('in' , $ids);
		else
			$this->response( array('info' => C('errorcode.3001') , 'code' => 3001), 'json' );
		if( $post['points'] && $post['points']>0 ){//使用积分支付
			if( $post['points'] < C('LEAST_POINTS') ) $this->response( array('info' => "积分至少".C('LEAST_POINTS')."个起兑" , 'code' => 3010), 'json' );
			if( $post['points']*C('POINTS_TO_HK') > ($data['shipping_fee']+$data['pay_fee']+$data['pack_fee']+$goods_money)*C('MOST_POINTS_HK') ) $this->response( array('info' => "积分支付不能超过订单总额的".C('MOST_POINTS_HK') , 'code' => 3011), 'json' );
			$post['points'] = intval( $post['points'] );
			$member = M('Member')->where( array('id'=>$post['uid']) )->find();
			if( $member['pay_points'] >= $post['points'] ){
				if ( freezePoints($post['points'] , $data['order_sn'] , $post['uid'] , '冻结积分' , 1) ){
					$data['paid_points'] = $post['points'];
					$data['paid_money'] = $post['points']/C('POINTS_TO_HK');
				}
			}
		}
		if( $post['coupon'] ){//电子优惠券
			$coupon = M('Coupon')->where( array('coupon'=>$post['coupon']) )->find();
			if( $coupon['user'] == '' && $coupon['expire_time']<time() ){//该券没有被使用过且还在使用期
				if( M('Coupon')->save( array('id'=>$coupon['id'],'user'=>$post['uid']) ) ){
					$coupon_his['coupon'] = $coupon['coupon'];
					$coupon_his['uid'] = $post['uid'];
					$coupon_his['add_time'] = time();
					$coupon_his['remark'] = $data['order_sn'];
					M('Coupon_his')->add($coupon_his);
					$data['paid_money'] += $coupon['amount'];
					$data['coupon'] = $coupon['coupon'];
					$data['paid_coupon'] = $coupon['amount'];
				}
			}
		}
		$order_id = M('Order')->add($data);
		if( !$order_id ) $this->response( array('info' => C('errorcode.3002') , 'code' => 3002), 'json' );
		$one_goods = array();
		foreach($goods as $k => $v){
			$one_goods = array(
				'order_id' => $order_id,
				'order_sn' => $data['order_sn'],
				'goods_id' => $v['id'],
				'goods_sn' => $v['serial'],
				'goods_name' => $v['name'],
				'goods_price' => $v['pricespe']!=0 ? $v['pricespe'] : $v['price'],
				'goods_num' => $post['goods'][$k]['num'],
				'money_goods' => ( $v['pricespe']!=0 ? $v['pricespe'] : $v['price'] ) * $post['goods'][$k]['num'],
			);
			$attr = '';//var_dump($post['goods'][$k]['attr']);die;
			if( $post['goods'][$k]['attr'] ){
				$attrinfo = M("Goods_attr")->field('id,attr_price,attr_value')->where( array( 'id'=>array('in' , $post['goods'][$k]['attr']) ) )->select();
				$attr = '';
				foreach( $attrinfo as $attrinfo_value ){
					$attr_total_price += $attrinfo_value['attr_price'];
					$attr .= $attrinfo_value['attr_value'].'   ';
				}
				$one_goods['goods_price'] += $attr_total_price*$post['goods'][$k]['num'];
				$one_goods['money_goods'] += $one_goods['goods_price']*$post['goods'][$k]['num'];
				$one_goods['goods_attr'] = $attr;
			}
			if( !M('Order_goods')->add( $one_goods) ) $fail[] = 1;
			M("Goods")->where( array('id'=>$v['id']) )->setDec('stock' , $post['goods'][$k]['num']);
		}
		D('Common/Order')->sync_money($order_id);//把商品总价格同步到order表中
		if( count($goods) == count($fail) ){
			$this->response( array('info' => C('errorcode.3004') , 'code' => 3004) , 'json' );
		}else if( count($fail)>0 ){
			$this->response( array('info' => C('errorcode.3005') , 'code' => 3005) , 'json' );
		}else if( count($fail) == 0 ){
			$this->response( array('info' => array('order_sn'=>$data['order_sn'],'order_id'=>$order_id) , 'code' => 3000), 'json' );
		}
	}
}