<?php
namespace Common\Model;
use Common\Model\CommonModel;
class ShippingModel extends CommonModel {
	public function get_Shipping()
	{
		return $this->select();
	}
	
	public function getArea($shipping_id=''){
		if(isset($shipping_id)){
			return M('Shipping_area')->where("shipping_id=$shipping_id")->select();
		}else{
			return M('Shipping_area')->select();
		} 
	}
	
	public function getShipping(){
		return $this->alias('s')->join("left join ".C('DB_PREFIX')."shipping_area a on s.id=a.shipping_id")->field('s.id shipping_id,s.name,s.insure,s.remark,s.status, a.name area,a.config,a.base_fee,a.step_fee,a.free_money')->where(array('s.status'=>1))->select();
	}
}