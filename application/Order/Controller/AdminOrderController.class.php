<?php
/*
@author lf
@email job@feehi.com
@description order modules
**/
namespace Order\Controller;
use Common\Controller\AdminbaseController;
class AdminOrderController extends AdminbaseController {
	
	private $payMethod;
	private $expressMethod;
	private $package;
	private $card;
	protected $order_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->order_obj = D("Common/Order");
		$this->payMethod = getPaymentMethod();
		$this->expressMethod = getExpressMethod();
	}
	
	public function index() {
		$where_ands = array();
		if($_REQUEST['start_time'] && $_REQUEST['end_time']){
			$where_ands['o.add_time'] = array('between' , 
										array(strtotime($_REQUEST['start_time']) , strtotime($_REQUEST['end_time']))
										);
		}else if($_REQUEST['start_time']){
			$where_ands['o.add_time'] = array('EGT' , strtotime($_REQUEST['start_time']));
		}else if($_REQUEST['end_time']){
			$where_ands['o.add_time'] = array('ELT' , strtotime($_REQUEST['end_time']));
		}
		$where_ands['o.order_status'] = $_REQUEST['order_status'];
		if($_REQUEST['order_status'] == -1 || $_REQUEST['order_status'] == ''){
			$_REQUEST['order_status'] = -1;
			unset($where_ands['o.order_status']);
		}
		$where_ands['o.shipping_status'] = $_REQUEST['shipping_status'];
		if($_REQUEST['shipping_status'] == -1 || $_REQUEST['pay_status'] == '') unset($where_ands['o.shipping_status']);
		$where_ands['o.pay_status'] = $_REQUEST['pay_status'];
		if($_REQUEST['pay_status'] == -1 || $_REQUEST['pay_status'] == '') unset($where_ands['o.pay_status']);
		if($_REQUEST['country']) $where_ands['o.country'] = $_REQUEST['country'];
		if($_REQUEST['province']) $where_ands['o.province'] = $_REQUEST['province'];
		if($_REQUEST['city']) $where_ands['o.city'] = $_REQUEST['city'];
		if($_REQUEST['district']) $where_ands['o.district'] = $_REQUEST['district'];
		$fields=array(
				'consignee'  => array("field"=>"o.consignee","operator"=>"="),
				'order_sn'  => array("field"=>"o.order_sn","operator"=>"="),
				'email'  => array("field"=>"o.email","operator"=>"="),
				'buy_user'  => array("field"=>"o.user_login","operator"=>"="),
				'address'  => array("field"=>"o.address","operator"=>"="),
				'tel'  => array("field"=>"o.tel","operator"=>"="),
				'mobile'  => array("field"=>"o.mobile","operator"=>"="),
				'shipping_id'  => array("field"=>"o.shipping_id","operator"=>"="),
				'pay_id'  => array("field"=>"o.pay_id","operator"=>"="),
		);
		if(IS_POST){
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && '' != $_POST[$param] ) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
			$_GET = $_POST;
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && '' != $_GET[$param] ) {
					$operator=$val['operator'];
					$field   =$val['field'];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
        }
		$this -> assign('where' , $_REQUEST);
		$count = M('Order o')->where($where_ands)->count('o.order_id');
		$page = $this->page($count, 1);
		$list = M('Order o')->field('o.*,u.user_login user')->join('left join '.C('DB_PREFIx').'users u on o.user_id = u.id')->where($where_ands)->limit($page->firstRow . ',' . $page->listRows)->select();//var_dump($list);die;
		foreach($list as $k => $v){
			$list[$k] = $v;
			$ids = $v['country'].','.$v['province'].','.$v['city'].','.$v['district'];
			$list[$k]['addr'] = M('Region')->where("id in ($ids)")->select();//echo $list[$k]['addr'];die;
		}
		$this -> assign('list' , $list);
		$this -> assign('Page' , $page->show('Admin'));
        $this -> display();
        
    }
	
	public function edit()
	{
		$id = intval(I('get.id'));
		$detail = M('Order o')->field('o.*,u.user_login user')->join('left join '.C('DB_PREFIX')."member u on o.user_id=u.id")->where("o.order_id = $id")->find();
		$ids = $detail['country'].','.$detail['province'].','.$detail['city'].','.$detail['district'];
		$detail['addr'] = M('Region')->where("id in ($ids)")->select();
		$this -> assign('detail' , $detail);
		$this -> assign('package' , $this->order_obj->get_order_goods($id));
		$this -> assign('action' , M('Order_action')->where("order_id = $id")->order('action_id desc')->select());
		$this -> assign('next' , $this->order_obj->where("order_id>$id")->find());
		$this -> assign('prev' , $this->order_obj ->order('order_id desc')->where("order_id<$id")->find());
		$this -> display();
	}
	
	/*
	public function edit_post()
	{
		$data = $_REQUEST;
		$result = $this -> order_obj->where("order_id={$data['order_id']}")->field('pay_status,order_status')->find();
		if($data['order_status'] ==2 && $result['pay_status'] != 1 || $result['order_status'] == 255) $this->error('发货失败,用户还未付款或订单已取消');
		if($data['order_status'] ==1 && $result['order_status'] >2) $this->error('用户已收货或者订单失效,不能修改发货状态');
		
		if($this->order_obj->save($data) !== false){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
	*/
	
	public function delete()
	{
		if($this->order_obj->where("order_id = {$_GET['id']} && (order_status=2 or order_status=3)")->delete()) $this->success('删除成功');
		$this -> error('删除失败');
	}
	
	public function confirm_multiple()
	{
		$in = implode(',',$_POST['ids']);
		$map['order_id'] = array('in' , $in);
		$result = $this -> order_obj -> where($map) -> select();
		foreach($result as $v){
			if(in_array($v['order_status'] , array(0 , 2 , 3))){
				$data['order_status'] = 1;
				if(!$this->order_obj->where("order_id={$v['order_id']}")->save($data)){
					$fail[] = $v['order_sn'];
				}else{
					$log['order_id'] = $v['order_id'];
					$log['action_user'] = $log['action_user'] = $this -> admin['user_login'];
					$log['pay_status'] = $v['pay_status'];
					$log['shipping_status'] = $v['shipping_status'];
					$log['log_time'] = time();
					$log['action_note'] = '批量操作';
					$log['order_status'] = $data['order_status'];
					M('Order_action') -> add($log);
				}
			}else{
				$fail[] = $v['order_sn'];
			}
		}
		if(is_array($fail)){
			$in = implode(',',$fail);
			$this -> error("以下订单:<font color='red'>{$in}</font>确认失败");
		}else{
			$this -> success('批量确认成功');
		}
	}
	
	public function disable_multiple()
	{
		$in = implode(',',$_POST['ids']);
		$map['order_id'] = array('in' , $in);
		$result = $this->order_obj->where($map)->select();
		foreach($result as $v){
			if($v['order_status'] <= 2 && $v['shipping_status'] <= 1){
				$data['order_status'] = 3;
				if(!$this -> order_obj->where("order_id={$v['order_id']}")->save($data)){
					$fail[] = $v['order_sn'];
				}else{
					$log['order_id'] = $v['order_id'];
					$log['action_user'] = $log['action_user'] = $this -> admin['user_login'];
					$log['pay_status'] = $v['pay_status'];
					$log['shipping_status'] = $v['shipping_status'];
					$log['log_time'] = time();
					$log['action_note'] = '批量操作';
					$log['order_status'] = $data['order_status'];
					M('Order_action')->add($log);
				}
			}else{
				$fail[] = $v['order_sn'];
			}
		}
		if(is_array($fail)){
			$in = implode(',',$fail);
			$this->error("以下订单:<font color='red'>{$in}</font>无效失败");
		}else{
			$this->success('批量确认成功');
		}
	}
	
	public function cancel_multiple()
	{
		$in = implode(',',$_POST['ids']);
		$map['order_id'] = array('in' , $in);
		$result = $this->order_obj -> where($map)->select();
		foreach($result as $v){
			if($v['order_status'] <= 1 && $v['shipping_status'] <= 1){
				$data['order_status'] = 2;
				if(!$this -> order_obj -> where("order_id={$v['order_id']}") -> save($data)){
					$fail[] = $v['order_sn'];
				}else{
					$log['order_id'] = $v['order_id'];
					$log['action_user'] = $log['action_user'] = $this->admin['user_login'];
					$log['pay_status'] = $v['pay_status'];
					$log['shipping_status'] = $v['shipping_status'];
					$log['log_time'] = time();
					$log['action_note'] = '批量操作';
					$log['order_status'] = $data['order_status'];
					M('Order_action')->add($log);
				}
			}else{
				$fail[] = $v['order_sn'];
			}
		}
		if(is_array($fail)){
			$in = implode(',',$fail);
			$this->error("以下订单:<font color='red'>{$in}</font>取消失败");
		}else{
			$this->success('批量确认成功');
		}
	}
	
	public function delete_multiple()
	{
		$in = implode(',',$_POST['ids']);
		$map['order_id'] = array('in' , $in);
		$result = $this->order_obj->where($map)->select();
		foreach($result as $v){
			if($v['order_status'] == 2 || $v['order_status'] == 3){
				if(!$this -> order_obj->where("order_id={$v['order_id']}")->delete()) $fail[] = $v['order_sn'];
			}else{
				$fail[] = $v['order_sn'];
			}
		}
		if(is_array($fail)){
			$in = implode(',',$fail);
			$this->error("以下订单:<font color='red'>{$in}</font>删除失败");
		}else{
			$this->success('批量删除成功');
		}
	}
	
	public function admin_order()
	{
		$data = I('post.');
		$log['order_id'] = $status['order_id'] = $data['order_id'];
		$result = $this->order_obj->where("order_id={$data['order_id']}")->find();

		$log['order_status'] = $result['order_status'];
		$log['pay_status'] = $result['pay_status'];
		$log['shipping_status'] = $result['shipping_status'];
		switch($data['action']){
			case 1://确认
				if($result['order_status'] !=0 && $result['order_status'] !=2 && $result['order_status'] !=3) $this -> error('不允许修改');
				$log['order_status'] = $status['order_status'] = 1;
				break;
			case 2://取消
				if($result['order_status'] > 1 || $result['shipping_status'] == 1) $this -> error('不允许修改');
				$log['order_status'] = $status['order_status'] = 2;
				break;
			case 3://无效
				if($result['order_status'] >= 4 || $result['shipping_status'] == 1) $this -> error('不允许修改');
				$log['order_status'] = $status['order_status'] = 3;
				break;
			case 4://付款
				if($result['order_status']!=1 || $result['pay_status'] !=0) $this -> error('不允许修改');
				$log['pay_status'] = $status['pay_status'] = 1;
				$status['pay_time'] = time();
				break;
			case 5://未付款
				if($result['shipping_status'] == 2 || $result['pay_status'] == 0) $this -> error('不允许修改');
				$log['pay_status'] = $status['pay_status'] = 0;
				$status['pay_time'] = 0;
				break;
			case 100://发货
				if($result['shipping_status'] == 2 || $result['pay_status'] == 0 || $result['shipping_status'] == 3) $this -> error('不允许修改');
				if( $data['shipping_sn'] == '' ) $this->error("发货单号不能为空");
				$log['shipping_status'] = $status['shipping_status'] = 2;
				$status['shipping_time'] = time();
				$status['shipping_sn'] = $data['shipping_sn'];
				break;
			case 6://去发货
				$this->redirect('shipping' , array('order_id' => $data['order_id']));
				exit;
			case 9://移除
				if($result['order_status'] != 2 && $result['order_status'] != 3 ) $this -> error('不允许修改');
				if($this->order_obj -> where("order_id={$data['order_id']}")->delete()){
					$this->success('移除成功');
				}else{
					$this->error('移除失败');
				}
		}
		if($this -> order_obj -> save($status)){
			$log['log_time'] = time();
			$log['action_note'] = $data['action_note'];
			$log['action_user'] = $this -> admin['user_login'];
			M('Order_action')->add($log);
			$this->success('操作成功');
		}else{
			$this->error('操作失败');
		}
	}
	
	public function search()
	{
		$map['type']=0;
		$this->country=D('Region')->where($map)->select();
		$this -> display();
	}
	
	public function shipping()
	{
		$id = intval($_GET['order_id']);
		$detail = M('Order o')->field('o.*,u.user_login')->join('left join '.C('DB_PREFIx')."users u on o.user_id=u.id")->where("o.order_id = $id")->find();
		$this->assign('detail' , $detail);
		$goods = M('Order_goods')->where( array('order_id'=>$id) )->select();
		$this->assign('goods' , $goods);
		$this->assign('action' , M('Order_action')->where("order_id = $id")->order('action_id desc')->select());
		$this->display();
	}
	
	public function print_order()
	{
		$id = intval($_GET['order_id']);
		$detail = M('Order o')->join('left join '.C('DB_PREFIx')."users u on u.id=o.user_id")-> field('u.user_login,o.*')-> where("order_id=$id")->find();
		$ids = $detail['country'].','.$detail['province'].','.$detail['city'].','.$detail['district'];
		$detail['addr'] = M('Region')->where("id in ($ids)")->select();//var_dump($detail['addr']);die;//echo $list[$k]['addr'];die;
		$this->assign('detail' , $detail);
		$this->assign('goods' , M('Order_goods')->where("order_id = $id")->select());
		$this->assign('info' , array('time'=>date('Y-m-d H:i:s') , 'operator' => $this -> admin['user_login']));
		$this->display();
	}
	
	public function edit_pay()
	{
		$order_id = intval(I('get.id'));
		$res = $this->order_obj->where("order_id=$order_id")->find();
		if($res['pay_status'] == 1) $this->error('用户已付款成功,不允许修改');
		$this->assign('detail' , $res);
		$this->assign('rows' , $this->payMethod);
		$this->display();
	}
	
	public function do_edit_pay()
	{
		$dt = I('post.');
		$data['order_id'] = $dt['order_id'];
		$pay = M('Payment')->where(array('id'=>$dt['pay_id']))->find();
		$data['pay_name'] = $pay['name'];
		$data['pay_id'] = $pay['id'];
		$data['pay_fee'] = $pay['pay_fee'];
		$origin = $this->order_obj->where("order_id={$data['order_id']}")->field('pay_fee,money_total')->find();
		$data['money_total'] = $origin['money_total'] - $origin['pay_fee'] + $data['pay_fee'];
		if($this->order_obj->save($data)){
			$this->success('更改成功',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}else{
			$this->error('更改失败',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}
	}
	
	public function edit_express()
	{
		$order_id = intval($_GET['id']);
		$res = $this -> order_obj->where("order_id=$order_id")->find();
		if($res['shipping_status'] > 1) $this->error('已经发货,不允许修改');
		$this -> assign('detail' , $res);
		$expressFee = setShippingFee($res['country'],$res['province'],$res['city'],$res['weight']);
		$this -> assign('rows' , $expressFee);
		$this -> display();
	}
	
	public function do_edit_express()
	{
		$dt = I('post.');
		$data['order_id'] = $dt['order_id'];
		$data['shipping_name'] = $this->expressMethod[$dt['shipping_id']]['name'];
		$data['shipping_id'] = $this->expressMethod[$dt['shipping_id']]['shipping_id'];
		$origin = $this-> order_obj-> where("order_id={$data['order_id']}")->field('shipping_fee,insure_fee,money_total,country,province,city,weight')->find();
		$fees = getShippingFee($origin['country'],$origin['province'],$origin['city'],$origin['weight'],$data['shipping_id']);
		if(!is_array($fees)) $this->error('该快递暂时无法到达该地区');
		$data['shipping_fee'] = $fees['shipping_fee'];
		$data['is_insure'] = 0;
		$data['insure_fee'] = 0;
		if(I('post.insure') == 1){
			$data['is_insure'] = 1;
			$data['insure_fee'] = $fees['insure_fee'];
		}
		if($origin['money_total'] > $fees['free_money']){//可能需要修改-订单金额大于一定数目,免运费
			$data['shipping_fee'] = $data['insure_fee'] = 0;
		}
		$data['money_total'] = $origin['money_total'] - $origin['shipping_fee'] + $data['shipping_fee'] + $data['insure_fee'] - $origin['insure_fee'];
		if($this->order_obj->save($data)){
			$this->success('更改成功',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}else{
			$this->error('更改失败',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}
	}
	
	public function edit_other()
	{
		$order_id = intval(I('get.id'));
		$res = $this -> order_obj -> where("order_id=$order_id") -> find();
		if($res['shipping_status'] == 1) $this -> error('已经发货,不允许修改');
		$this->assign('detail' , $res);
		$this->assign('package' , C('PACKAGE'));
		$this->assign('card' , $this->card);
		$this->display();
	}
	
	public function do_edit_other()
	{
		$data = I('post.');
		if($data['package_id'] == 0){
			$data['package_fee'] = $data['package_id'] = 0;
			$data['package_name'] = '';
		}else{
			$data['package_id'] = $this->package[$data['package_id']]['id'];
			$data['package_name'] = $this->package[$data['package_id']]['name'];
			$data['package_fee'] = $this->package[$data['package_id']]['fee'];
		}
		if($data['card_id'] == 0){
			$data['card_fee'] = $data['card_id'] = 0;
			$data['card_name'] = '';
		}else{
			$data['card_id'] = $this->card[$data['card_id']]['id'];
			$data['card_name'] = $this->card[$data['card_id']]['name'];
			$data['card_fee'] = $this->card[$data['card_id']]['fee'];
		}
		$origin = $this->order_obj->where("order_id={$data['order_id']}")->field('money_total,card_fee,package_fee')->find();
		$data['money_total'] = $origin['money_total'] - $origin['card_fee'] - $origin['package_fee'] + $data['card_fee'] + $data['package_fee'];
		if($this->order_obj -> save($data)){
			$this->success('更改成功',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}else{
			$this->error('更改失败',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}
	}
	
	public function edit_address()
	{
		$order_id = intval(I('get.id'));
		$res = $this->order_obj->where("order_id=$order_id")->find();
		if($res['shipping_status'] == 1) $this->error('已经发货,不允许修改');
		$this->assign('detail' , $res);
		$map['type']=0;
		$this->country=D('Region')->where($map)->select();
		$map['type']=1;
		$this->province=D('Region')->where($map)->select();
		$map['type']=2;
		$this->city=D('Region')->where($map)->select();
		$map['type']=3;
		$this->district=D('Region')->where($map)->select();
		$this->display();
	}
	
	public function do_edit_address()
	{
		$data = I('post.');
		if($this->order_obj->save($data)){
			$this->success('更改成功',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}else{
			$this->error('更改失败',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}
	}
	
	public function edit_goods()
	{
		$order_id = intval($_REQUEST['id']);
		$res = $this->order_obj->where("order_id=$order_id")->find();
		if($res['shipping_status'] == 1) $this -> error('已经发货,不允许修改');
		/*商品搜索*/
		if($_REQUEST['keyword'] && $_POST['type']!='加入订单'){
			$data['id'] = $_REQUEST['keyword'];
			$data['_logic'] = 'OR';
			$data['serial'] = $_REQUEST['keyword'];
			$data['name'] = $_REQUEST['keyword'];
			$data['seo_keywords'] = array('like' , '%'.$_REQUEST['keyword'].'%');
			$res = M('Goods')->where($data)->select();
			$this->assign('keyword' , $_REQUEST['keyword']);
			$search_display = 0;
			if($_GET['search_display']) $search_display = $_GET['search_display'] - 1;
			$this->assign('search_display' , $search_display);
			$this->assign('goods' , $res);
		}
		/*商品搜索*/
		//添加商品到订单
		if($_POST['goods_id'] && $_POST['type']!='搜索'){
			if($_POST['goods_num'] <= 0 || !$_POST['goods_num']) $this -> error('商品数量不能小于0和为空');
			$save['order_id'] = $order_id;
			$save['goods_id'] = $_POST['goods_id'];
			$save['goods_name'] = $_POST['goods_name'];
			$save['goods_price'] = $_POST['goods_price'] == 'user_input' ? $_POST['input_price'] : $_POST['goods_price'];
			$save['goods_num'] = $_POST['goods_num'];
			$save['goods_sn'] = $_POST['goods_sn'];
			$save['goods_attr'] = $_POST['goods_attr'];
			M('Order_goods')->add($save);
			$this->order_obj->sync_money($order_id);
		}
		//添加商品到订单
		$this -> assign('order_id' , $order_id);//var_dump($this -> order_obj ->field('*,sum(goods_price*goods_num) total') -> where("order_id=$order_id") -> select());die;
		$this -> assign('rows' , $this->order_obj->get_order_goods($order_id));
		$this -> assign('total' , $this->order_obj->get_order_money($order_id));
		$this -> display();
	}
	
	public function edit_goods_package()
	{
		$data = I('post.');
		foreach($data['id'] as $k => $v){
			$save['id'] = $v;
			$save['goods_price'] = $data['goods_price'][$k];
			$save['goods_attr'] = $data['goods_attr'][$k];
			$save['goods_num'] = $data['goods_num'][$k];
			M('Order_goods')->save($save);
		}
		$this->order_obj->sync_money(intval(I('post.order_id')));
		$this->success('商品更新成功');
	}
	
	public function edit_goods_del()
	{
		$id = intval(I('get.id'));
		if( M('order_goods')->where("id=$id")->delete()){
			$this->order_obj->sync_money(intval($_REQUEST['order_id']));
			$this->success('删除成功');
		}else{
			$this->error('删除失败');
		}
	}
	
	public function edit_fee()
	{
		$order_id = intval($_GET['id']);
		$res = $this->order_obj->where("order_id=$order_id")->find();
		if($res['pay_status'] == 1) $this->error('已经付款,不允许修改');
		$this -> assign('detail' , $res);
		$this -> display();		
	}
	
	public function do_edit_fee()
	{
		$data = I('post.');
		$origin = $this->order_obj->where("order_id={$data['order_id']}")->field('money_total,receipt_fee,shipping_fee,insure_fee,pay_fee,package_fee,card_fee,discount')->find();
		$data['money_total'] = $origin['money_total'] - $origin['receipt_fee'] - $origin['shipping_fee'] - $origin['insure_fee'] - $origin['pay_fee'] - $origin['package_fee'] - $origin['card_fee'] + $data['receipt_fee'] + $data['shipping_fee'] + $data['insure_fee'] + $data['pay_fee'] + $data['package_fee'] + $data['card_fee'] + $origin['discount'] - $data['discount'];
		if($this->order_obj -> save($data)){
			$this->success('更改成功',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}else{
			$this->success('更改失败',U('AdminOrder/edit',array('id' => $data['order_id'])));
		}
	}
	
	//运费计算器
/*	private function setShippingFee($country,$province,$city,$weight){
		//var_dump($this->expressMethod);die;
		//echo $country.'-';echo $province.'-';echo $city.'-';echo $weight;
		foreach($this->expressMethod as $k => $v){
			foreach($v['addr'] as $key => $value){
				if( in_array($city , $value['config']) || in_array($province , $value['config']) || in_array($country , $value['config']) ){
					$this->expressMethod[$k]['free_money'] = $value['free_money'];
					if(10 - $weight >= 0){
						$this->expressMethod[$k]['fee'] = $value['base_fee'];
					}else{
						$overMoney = abs(ceil(10 - $weight))*$value['step_fee'];
						$this->expressMethod[$k]['fee'] = $value['base_fee'] + $overMoney;
					}
				}
			}
		}
	}*/
	public function confirm(){
		$id = I('get.id');
		$data = array();
		$result = M("Order")->where( array('order_id'=>$id) )->find();
		if( $result['receive_time'] != 0 ) $this->error("此订单已经确认过了");
		if( $result['pay_status'] == 0 ) $this->error("此订单还未支付");
		if( $result['shipping_status'] == 0 ) $this->error("此订单还未发货");
		if( M('Order')->where( array('order_id'=>$id) )->save( array('receive_time'=>time()) ) ){
			if( $result['paid_points']!=0 ) confirmFreezePoints(-$result['paid_points'] , $result['order_sn'] , $result['user_id'] , "消费成功" , 1);
			points(floor($result['paid_money']/C('ORDER_SEND_POINTS')) , $result['order_sn'] , $result['user_id'] , "订单赠送积分" , 'default');//购物送积分
			$this->success("确认成功");
		}else{echo M('Order')->getLastSql();die;
			$this->error("确认失败");
		}
	}
	
}

