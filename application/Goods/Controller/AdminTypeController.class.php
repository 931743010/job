<?php
namespace Goods\Controller;
use Common\Controller\AdminbaseController;
class AdminTypeController extends AdminbaseController {
	
	protected $type_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->type_obj = D("Common/Type");
	}
	
	function index(){
		$lists=$this->type_obj->order(array("id"=>"asc"))->select();
		$this->assign("lists",$lists);
		Cookie( '__forward__', $_SERVER['REQUEST_URI'] );
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			if ($this->type_obj->create()) {
				if ($this->type_obj->add()!==false) {
					$this->success("添加成功！", Cookie('__forward__') );
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->type_obj->getError());
			}
		
		}
	}
	
	
	
	function edit(){
		$id=I("get.id");
		$detail=$this->type_obj->where("id=$id")->find();
		$this->assign($detail);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->type_obj->create()) {
				if ($this->type_obj->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->type_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->type_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	//删除
	function delete(){
		if(isset($_POST['ids'])){
			
		}else{
			$id = intval(I("get.id"));
			if ($this->type_obj->delete($id)!==false) {
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
			if ($this->type_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->type_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}