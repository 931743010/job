<?php 
namespace Order\Controller;
use Common\Controller\AdminbaseController;

class AdminShippingController extends AdminbaseController {
	protected $shipping_obj;
	
	function _initialize() {
			$this->shipping_obj = D('Common/Shipping');
	}
	
	public function index()
	{
		$this->assign('rows' , $this->shipping_obj->get_shipping());
		$this->display();
	}
	
	public function add(){
		$this->display();
	}
	
	public function do_add()
	{
		$data = I('post.');
		if($this->shipping_obj->add($data)){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	public function edit()
	{
		$id = I('get.id');
		$this->assign('detail' , $this->shipping_obj->where("id=$id")->find());
		$this->display();
	}
	
	public function do_edit()
	{
		$data = I('post.');
		if($this->shipping_obj->save($data)){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
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
		$num = $this->shipping_obj->where($where)->delete();
		if($num !== false){
			$this->success("成功删除{$num}条");
		}else{
			$this->error("删除失败");
		}
	}
	
	public function list_area()
	{
		$shipping_id = I('get.id');
		$res = $this->shipping_obj->getArea($shipping_id);
		foreach($res as $k => $v){
			$res[$k] = $v;
			$res[$k]['addr'] = implode( ',' , json_decode($v['config']) );
			$res[$k]['addr'] = M('Region')->field('name')->where("id in ({$res[$k]['addr']})")->select();
		}
		$this->assign('rows' , $res);
		$this->display();
	}
	
	public function add_area()
	{
		$map['type']=0;
		$this->country=D('Region')->where($map)->select();
		$this -> display();
	}
	
	public function getRegion(){
		$dao=D("Region");
		$map['pid']=$_REQUEST["pid"];
		$map['type']=$_REQUEST["type"];
		$list=$dao->where($map)->select();//echo $list;die;
		echo json_encode($list);
	}
	
	public function do_add_area()
	{
		$data = I('post.');
		if( !$data['config'] ) $this->error("区域不能为空,请记得点击+,添加地区");
		$data['config'] = json_encode($data['config']);
		if(M('Shipping_area')->add($data)){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	
	public function delete_area()
	{
		$ids = I('post.ids');
		$id = I('get.id');
		if(is_array($ids)){
			$where = "id in(".implode(',',$ids).")";
			
		}else if(isset($id)){
			$where = "id=".$id;
		}
		$num = M('Shipping_area')->where($where)->delete();
		if($num !== false){
			$this->success("成功删除{$num}条");
		}else{
			$this->error("删除失败");
		}
	}
	
	public function edit_area()
	{
		$id = I('get.id');
		$map['type']=0;
		$this->country=D('Region')->where($map)->select();
		$res = M('Shipping_area')->where("id=$id")->find();
		$res['config'] = json_decode($res['config']);
		$ids = implode(',' , $res['config']);
		$this->assign('addr' , M('Region')->where("id in(".$ids.")")->select());
		$this->assign('detail' , $res);
		$this->display();
	}

	public function do_edit_area()
	{
		$data = I('post.');
		$data['config'] = json_encode($data['config']);
		if(M('Shipping_area')->save($data)){
			$this->success('修改成功');
		}else{
			$this->error('修改失败');
		}
	}
	public function generate(){
		F('conf/express' , NULL);
		$expressMethod = getExpressMethod();
		if( is_array($expressMethod) ){
			$this->success('生成配置成功');
		}else{
			$this->error('生成配置失败');
		}
	}
}