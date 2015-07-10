<?php
namespace Common\Model;
use Common\Model\CommonModel;
use Think\Page;
class OrderModel extends CommonModel {
	
	//得到商品总价
	public function get_order_money($order_id)
	{
		return M('Order_goods')->where("order_id=$order_id")->sum("goods_price*goods_num");
	}
	//得到订单的商品信息
	public function get_order_goods($order_id)
	{
		return M('Order_goods')->where("order_id=$order_id")->select();
	}
	//把商品价格同步到订单表中
	public function sync_money($order_id)
	{
		$data = array();
		$data['order_id'] = $order_id;
		$data['money_goods'] = $this -> get_order_money($order_id);
		$res = M('Order')->where("order_id=$order_id")->find();
		$data['money_total'] = $data['money_goods'] + $res['pack_fee'] + $res['pay_fee'] + $res['shipping_fee'] + $res['insure_fee'] + $res['package_fee'] + $res['card_fee'] + $res['receipt_fee'] - $res['discount'];
		M('Order') -> save($data);
	}
	//前台获取订单列表
	public function getOrders($rows , $map=array()){
		$count = $this->alias('o')->where($map)->count();
		$Page = page($count , $rows);
		//$field = 'o.order_id,o.order_sn,o.order_status,o.add_time,o.money_total,o.shipping_fee,og.goods_num,og.goods_attr,g.name,g.smallimage';
		//$list = $this->alias('o')->field($field)->join("left join ".C('DB_PREFIX')."order_goods og on o.order_id=og.order_id")->join("left join ".C('DB_PREFIX')."goods g on og.goods_id=g.id")->where($map)->limit($Page->firstRow.','.$Page->listRows)->select(false);
		$list = $this->field('order_id,order_sn,order_status,add_time,money_total,shipping_fee,pay_status,shipping_status,receive_time')->order('order_id desc')->limit($Page->firstRow.','.$Page->listRows)->where($map)->select();
		$goods_ids = '';$i = 0;
		foreach($list as $v){
			$i++;
			if( $i==1 ) 
				$goods_ids = $v['order_id'];
			else
				$goods_ids .= ','.$v['order_id'];
		}
		$goods = M('Order_goods og')->field('g.name,g.img_url,og.goods_num,og.goods_attr,og.order_id')->join("left join ".C('DB_PREFIX')."goods g on og.goods_id=g.id")->select();
		$order = '';//var_dump($goods);die;
		foreach($list as $k => $v){
			$order[$v['order_id']]['order_id'] = $v['order_id'];
			$order[$v['order_id']]['order_sn'] = $v['order_sn'];
			$order[$v['order_id']]['order_status'] = $v['order_status'];
			$order[$v['order_id']]['money_total'] = $v['money_total'];
			$order[$v['order_id']]['shipping_fee'] = $v['shipping_fee'];
			$order[$v['order_id']]['add_time'] = $v['add_time'];
			$order[$v['order_id']]['pay_status'] = $v['pay_status'];
			$order[$v['order_id']]['shipping_status'] = $v['shipping_status'];
			$order[$v['order_id']]['receive_time'] = $v['receive_time'];
			foreach($goods as $key => $val){
				if($val['order_id'] == $v['order_id']){
					$order[$v['order_id']]['order_goods'][] = array(
																	'name' => $val['name'],
																	'goods_num' => $val['goods_num'],
																	'goods_attr' => $val['goods_attr'],
																	'pic' => $val['img_url'],
																	);
				}
			}
		}//var_dump($order);die;
		/**$order = '';echo $list;die;
		foreach($list as $k => $v){
			$order[$v['order_id']]['order_sn'] = $v['order_sn'];
			$order[$v['order_id']]['order_status'] = $v['order_status'];
			$order[$v['order_id']]['money_total'] = $v['money_total'];
			$order[$v['order_id']]['shipping_fee'] = $v['shipping_fee'];
			$order[$v['order_id']]['add_time'] = $v['add_time'];
			$order[$v['order_id']]['order_goods'][] = array(
															'name' => $v['name'],
															'goods_num' => $v['goods_num'],
															'pic' => $v['smallimage'],
															'goods_attr' => $v['goods_attr'],
															);
		}**/
		$return = '';
		$return['list'] = $order;
		$return['page'] = $Page->show('home');
		return $return;
	}
}