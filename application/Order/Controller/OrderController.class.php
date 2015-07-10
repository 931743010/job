<?php

/**
 * 搜索结果页面
 */
namespace Order\Controller;
use Common\Controller\HomeBaseController;
class OrderController extends HomeBaseController {
	private $user;
	public function _initialize(){
		if( !$_SESSION['user']['id'] ) $this->redirect(U('User/login/index'));
		$this->user = $_SESSION['user'];
		parent::_initialize();
	}
	
	public function generate(){
		$cart = A('Order/cart');
		$goods = array();//var_dump($cart->cart());die;
		foreach($cart->cart()['cart'] as $k => $v){
			$goods[] = array(
				'id' => $v['id'],
				'num' => $v['num'],
				'attr' => $v['attr'],
			);
		}
		$data = I('post.');
		if( !$data['address_id'] ) $this->error("请选择收货地址");
		$address = M('Member_address')->where( array('address_id'=>$data['address_id']) )->find();
		$data['country'] = $address['country'];
		$data['province'] = $address['province'];
		$data['city'] = $address['city'];
		$data['district'] = $address['district'];
		$data['address'] = $address['address'];
		$data['consignee'] = $address['consignee'];
		$data['tel'] = $address['tel'];
		$data['mobile'] = $address['mobile'];
		$data['email'] = $address['email'];
		$data['goods'] = $goods;
		$data['uid'] = $this->user['id'];
		//var_dump($data);die;
		$client = A('Common/Oauthclient');
		$orderInfo = $client -> createOrder($data);//var_dump($orderInfo->order_id);die;
		//$this->error("订单创建成功,订单编号{$orderInfo->order_sn}",U('Order/index/index'));
		/**$res = array(
			'status' => 1,
			'order_id' => $orderInfo->order_id,
		);
		echo json_encode($res);**/
		$this->success($orderInfo->order_id);
	}
	
	public function orderSuccess(){
		$this->assign( 'form' , getPayForm(I('get.id')) );
		$this->display();
	}
	
	public function payreturn(){
		$payMethod = I('get.paymentmethod');
		if( $payMethod == 1 ){
			$status = I('request.vpc_TxnResponseCode');
			if( $status != 0 ) $this->error('支付失败');
			$data['order_id'] = I('request.vpc_OrderInfo');
			$record['money'] = I('request.vpc_Amount')/100;
			$record['pay_sn'] = I('request.vpc_TransactionNo');
			$record['remark'] = 'card_type:'.I('request.vpc_CardType').';card:'.I('request.vpc_Card');
		}else if( $payMethod == 2 ){
			$status = I('get.status');
			if( $status == 'fail' ) $this->error('支付失败,请重新支付');
			if( $status == 'cancel' ) $this->error('取消订单行为');
			$data['order_id'] = I('request.Ref');
			$record['money'] = 0;
		}
		$data['order_status'] = 1;
		$data['pay_status'] = 1;
		$data['pay_time'] = time();
		$order = M('Order')->where( array('order_id'=>$data['order_id']) )->find();
		if( $record['money']==0 ) $record['money'] = $order['money_total'] - $order['paid_money'];//针对第二种付款方式无奈的做法
		//$affected_points = $order['money_total']
		//points($affected_points , $order_sn , $uid , $remark="" , $type='default')//购买成功,增加积分
		if(M('Order')->save($data)){
			$record['pay_type'] = $payMethod;
			$record['order_id'] = $data['order_id'];
			$record['add_time'] = time();
			M('pay_record')->add($record);
			M('Order')->where( array('order_id'=>$data['order_id']) )->setInc('paid_money' , $record['money']);
			if( $order['paid_points'] > 0 ){//部分使用了积分支付
				confirmFreezePoints(-$order['paid_points'] , $order['order_sn'] , $order['user_id'] , $remark="消费成功" , 1);
			}
			$this->redirect(U('order/order/paySuccess'));
		}else{
			$this->error('支付成功,但是订单状态更改失败,请联系客服处理' , U('Order/index/index'));
			//$this->redirect(U('order/order/paySuccess'));
		}
	}
	public function paySuccess(){
		$this->display();
	}
	public function payment(){
		$id = I('get.id');
		$order = M('Order')->where( array('order_id'=>$id) )->find();
		if( empty($order) ) $this->error("不存在的订单号");
		$this->assign( 'order' , $order );
		$this->assign( 'goods' , M('Order_goods')->where( array('order_id'=>$id) )->select() );
		$this->assign('form' , getPayForm($id));
		$this->display();
	}
	public function comment(){
		if ( !$_POST ){			
			$id = I('get.id', '', 'intval,trim,strip_tags');
			//订单详情
			$order = M('Order')->where( array('order_id' => $id, 'user_id' => $_SESSION['user']['id']) )->find();
			if( empty($order) ) $this->error("不存在的订单号");
			$order['time'] = ceil((time()-$order['add_time'])/(3600*24));//下单时间
			$order_goods = M('OrderGoods')->alias('OG')->where('order_id = '. $id)->join('Left join ' . C('DB_PREFIX') . 'goods g on g.id = OG.goods_id')->field('g.img_url g_img_url,goods_id,name')->select();
			$order_comment_model = M('CommentsGoods');
			$order_comments = array();
			foreach($order_goods as $v){//查看是否已有评价过
				$where['goods_id'] = $v['goods_id'];
				$where['order_id'] = $id;
				$where['uid'] = $_SESSION['user']['id'];
				$comments = $order_comment_model->where($where)->field('content,goods_id,order_id,type,img_url,thumb_url,uid,score')->select();
				if(!empty($comments)){//有评价
					if(count($comments) > 1){//多条评价
						foreach($comments as $key => $val){
							if(!empty($val['img_url'])){
								$comments[$key]['img_url'] = explode('|', $val['img_url']);
								$comments[$key]['thumb_url'] = explode('|', $val['thumb_url']);
							}
						}
					}else{//一条评价
						if(!empty($comments[0]['img_url'])){
							$comments[0]['img_url'] = explode('|', $comments[0]['img_url']);
							$comments[0]['thumb_url'] = explode('|', $comments[0]['thumb_url']);
						}
					}
				}
				$order_comments[$v['goods_id']]['goods'] = $v;
				$order_comments[$v['goods_id']]['comments'] = $comments;
			}
/*			echo "<pre>";
			print_r($order_goods);
			echo "</pre>";*/
			$this->assign('order_comments', $order_comments);
			$this->assign('order', $order);
			$this->display();
		} else {//添加评价
			
			if(isset($_POST['content'])){
				$this->ajaxReturn(array('error' => 1, 'msg' => '未填写任何评价内容'));
				exit;
			}
			extract($_POST);
						//获取用户邮箱（没有邮箱则获取手机号）	
			$user = M('Member')->where('id = ' . $_SESSION['user']['id'])->field('user_email,user_phone')->find();	
			$username = !empty($user['user_email']) ? $user['user_email'] : $user['user_phone'];
			$order_comment_model = M('CommentsGoods');
			$empty = true;
			foreach($content as $k => $v){
				if(empty($v)){
					continue;
				}
					$where['goods_id'] = $k;
					$where['order_id'] = $order_id;
					$where['uid'] = $_SESSION['user']['id'];
					//获取评价表，假如已存在评价信息，则type=2（追评），否则为1（初评）
					$count = $order_comment_model->where($where)->count();
					if($count == 0)
						$type = 1;
					else
						$type = 2;
				if(!empty($v) && (!empty($score[$k]) || $type == 2) && !empty($order_id) && !empty($k)){
					$thumb_url = empty($thumb_url[$k]) ? '' : implode('|', $thumb_url[$k]);
					$img_url = empty($thumb_url) ? '' : str_replace('small_', '', $thumb_url);
					$score[$k] = empty($score[$k]) ? 0 : $score[$k];
					$data = array(
								'goods_id' => $k,
								'order_id' => $order_id,
								'uid' => $_SESSION['user']['id'],
								'score' => $score[$k],
								'type' => $type,
								'img_url' => $img_url,
								'thumb_url' => $thumb_url,
								'username' => $username,
								'content' => $v,
								'createtime' => date('Y-m-d H:i:s')
							);
					$rs = $order_comment_model->data($data)->add();
					if($rs) $empty = false;
				}
			}
			if($empty){
				$this->ajaxReturn(array('error' => 1, 'msg' => '未填写任何评价内容'));
				exit;
			}else{
				$this->ajaxReturn(array('error' => 0, 'msg' => '评价成功'));
				exit;
			}
		}
		
	}
	/**
	 * @todo 订单详情
	 */
	function detail(){
		$this->display();
	}
}
