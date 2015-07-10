<?php
namespace Common\Model;
use Common\Model\CommonModel;
class CouponModel extends CommonModel
{	
	//自动验证
	protected $_validate = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('num', 'require', '生成数量不能为空！', 1, 'regex', 1),
			array('name', 'require', '名称不能为空！', 3, 'regex', 3),
			array('start_time', 'require', '启用时间不能为空！', 3, 'regex', 3),
			array('expire_time', 'require', '到期时间不能为空！', 3, 'regex', 3),
			array('num','number','生成数量应为纯数字！'),
			array('start_time','_start_time','启用时间必须大于当前时间',0,'callback'),
			array('expire_time','_expire_time','到期时间必须大于启用时间',0,'callback'),
			
	);
	protected function _start_time(){
		if( strtotime( $_POST ['start_time'] ) < time() )
			return false;
		else 
			return true;
	}
	protected function _expire_time(){
		if( strtotime( $_POST ['expire_time'] ) < strtotime( $_POST ['start_time'] ) )
			return false;
		else
			return true;
	}
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}




