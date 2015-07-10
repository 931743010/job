<?php
namespace Goods\Controller;
use Common\Controller\AdminbaseController;
class AdminBrandController extends AdminbaseController {
	
	protected $brand_obj;	
	
	function _initialize() {
		parent::_initialize();
		$this->brand_obj = D("Common/Brand");
	}
	
	function index(){
		$lists = $this->brand_obj->order(array("listorder"=>"asc"))->select();
		$this->assign("lists", $lists);
		$this->display();
	}
	
	function add(){
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			if ($this->brand_obj->create()) {
				$_POST['imgurl']=sp_asset_relative_url($_POST['imgurl']);
				if ($this->brand_obj->add()!==false) {
					$this->success("添加成功！", U("AdminBrand/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->brand_obj->getError());
			}
		
		}
	}
	function edit(){
		$id=I("get.id");
		$data = $this->brand_obj->where("id=$id")->find();
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->brand_obj->create()) {
				$_POST['imgurl']=sp_asset_relative_url($_POST['imgurl']);
				if ($this->brand_obj->save()!==false) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->brand_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->brand_obj);
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
			if ($this->brand_obj->delete($id)!==false) {
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
			if ($this->brand_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->brand_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}