<?php
namespace Common\Model;
use Common\Model\CommonModel;
class GoodsModel extends CommonModel {
	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('name', 'require', '名称不能为空！', 3, 'regex', 3),
				
	);	
	protected $_auto = array (
		array ('create_date', 'mGetDate', 1, 'callback' ),
		array ('modify_date', 'mGetDate', 3, 'callback' ),
	);
	// 获取当前时间
	function mGetDate() {
		return date ( 'Y-m-d H:i:s' );
	}
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
}