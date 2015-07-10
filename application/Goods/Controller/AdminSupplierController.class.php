<?php
namespace Goods\Controller;
use Common\Controller\AdminbaseController;
class AdminSupplierController extends AdminbaseController {
	
	protected $supplier_obj;	
	
	function _initialize() {
		parent::_initialize();
		$this->supplier_obj = D("Common/Supplier");
	}
	
	function index(){
		$lists = $this->supplier_obj->order(array("id"=>"desc"))->select();
		$this->assign("lists", $lists);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			if ($this->supplier_obj->create()) {
				$_POST['imgurl']=sp_asset_relative_url($_POST['imgurl']);
				if ($this->supplier_obj->add()!==false) {
					$this->success("添加成功！", U("AdminSupplier/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->supplier_obj->getError());
			}
		
		}
	}
	function edit(){
		$id=I("get.id");
		$data = $this->supplier_obj->where("id=$id")->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->supplier_obj->create()) {
				$_POST['imgurl']=sp_asset_relative_url($_POST['imgurl']);
				if ($this->supplier_obj->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->supplier_obj->getError());
			}
		}
	}
	
	//删除
	function delete(){
		if(isset($_POST['ids'])){
			
		}else{
			$id = intval(I("get.id"));
			if ($this->supplier_obj->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	
	}
	
	/**
	 * 显示/隐藏
	 */
	function toggle(){
		if(isset($_POST['ids']) && $_GET["display"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=1;
			if ($this->supplier_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->supplier_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}