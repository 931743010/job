<?php 
namespace Order\Controller;
use Common\Controller\AdminbaseController;

class AdminPaymentController extends AdminbaseController {
	protected $payment_obj;
	
	public function _initialize() {
		$this->payment_obj = D('Common/Payment');
	}
	
	public function index(){
		$this->assign('rows' , $this->payment_obj->order('listorder')->select());
		$this->display();
	}
	
	public function listorders() {
		$status = parent::_listorders($this->payment_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	public function able() {
		$ids = implode( ',' , $_POST['ids'] );
		$data['status'] = 1;
		if($this->payment_obj->where("id in (".$ids.")")->save($data)){
			$this -> success('启用成功');
		}else{
			$this->error('启用失败');
		}
    }
	
	public function disable() {
		$ids = implode( ',' , $_POST['ids'] );
		$data['status'] = 0;
		if($this->payment_obj->where("id in (".$ids.")")->save($data)){
			$this -> success('禁用成功');
		}else{
			$this->error('禁用失败');
		}
    }
	
	public function delete() 
	{
		$ids = I('post.ids');
		$id = I('get.id');
		if(is_array($ids)){
			$where = "id in(".implode(',',$ids).")";
			
		}else if(isset($id)){
			$where = "id=".$id;
		}
		$num = $this->payment_obj->where($where)->delete();
		if($num !== false){
			$this->success("成功删除{$num}条");
		}else{
			$this->error("删除失败");
		}
	}
	
	public function add()
	{
		$this->display();
	}
	
	public function do_add(){
		$data = I('post.');
		if($this->payment_obj->add($data)){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	
	public function edit()
	{
		$id = I('get.id');
		$this->assign('detail' , $this->payment_obj->where(array('id'=>$id))->find());
		$this->display();
	}
	
	public function do_edit(){
		$data = I('post.');
		if($this->payment_obj->save($data)){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
}