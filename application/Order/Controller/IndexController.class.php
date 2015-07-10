<?php

/**
 * 搜索结果页面
 */
namespace Order\Controller;
use Common\Controller\HomeBaseController;
class IndexController extends HomeBaseController {
	private $obj;
	private $user;
	public function _initialize(){
		$this->obj = D("Common/Order");;
		if( !$_SESSION['user']['id'] ) $this->redirect(U('User/login/index'));
		$this->user = $_SESSION['user'];
		parent::_initialize();
	}

    public function index() {
		$map = array();
		if(IS_POST){
			$time = time();
			switch($_REQUEST['time']){
				case '3m' ://近3个月订单
						$map['add_time'] = array( 'between' , array( strtotime('-2 month') , $time ) );
						break;
				case '1w' ://最近一周
						$map['add_time'] = array( 'between' , array( strtotime('-7 day') , $time ) );
						break;
				case '3d' ://3天前
						$map['add_time'] = array( 'between' , array( strtotime('-3 day') , $time ) );
						break;
				case '1d' ://今天
						$map['add_time'] = array( 'between' , array( strtotime(date('Y-m-d')) , $time ) );
						break;
			}
			if( I('post.pay_status') || I('post.pay_status') == 0 ) $map['pay_status'] = I('post.pay_status');
			$_GET = $_POST;
			$this->assign('where' , $_GET);
		}
		$map['user_id'] = $this->user['id'];
		$map['user_status'] = 0;
		$this->assign( 'order' ,  $this->obj->getOrders(1 , $map) );
		$this->display();
    }
    
	public function delete(){
		$id = I('get.id');
		if(M('Order')->save(array('user_status'=>1,'order_id'=>$id)))
			$this->success('删除成功');
		else
			$this->error('删除失败');
	}
    
}
