<?php
namespace Goods\Controller;
use Common\Controller\AdminbaseController;
class AdminTypeAttrController extends AdminbaseController {
	
	protected $typeAttr_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->typeAttr_obj = D("Common/TypeAttr");
	}
	
	function index(){
		$id=I("get.id");
		$lists=$this->typeAttr_obj->where(array("type_id"=>$id))->order(array("id"=>"asc"))->select();
		$this->assign("id",$id);
		$this->assign("lists",$lists);
		Cookie ( '__forward__', $_SERVER ['REQUEST_URI'] );
		$this->display();
	}
	
	function add(){
		$type_id = I("get.type_id");
		$types = sp_sql_types();
		$this->assign("types",$types);
		$this->assign("type_id",$type_id);
		$this->display();
	}
	function add_post(){
		if(IS_POST){
			$type_id = I("post.type_id");
			unset( $_POST['id'] );
			if ($this->typeAttr_obj->create()) {
				if ($this->typeAttr_obj->add()!==false) {
					$this->success("添加成功！", Cookie ( '__forward__') );
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->typeAttr_obj->getError());
			}
		
		}
	}
	function edit(){
		$id=I("get.id");
		$detail=$this->typeAttr_obj->where("id=$id")->find();
		$this->assign($detail);
		$types = sp_sql_types();
		$this->assign("types",$types);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->typeAttr_obj->create()) {
				if ($this->typeAttr_obj->save()!==false) {
					$this->success("保存成功！", Cookie ( '__forward__') );
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->typeAttr_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->typeAttr_obj);
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
			if ($this->typeAttr_obj->delete($id)!==false) {
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
			if ($this->typeAttr_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("显示成功！");
			} else {
				$this->error("显示失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["hide"]){
			$ids = implode(",", $_POST['ids']);
			$data['status']=0;
			if ($this->typeAttr_obj->where("id in ($ids)")->save($data)!==false) {
				$this->success("隐藏成功！");
			} else {
				$this->error("隐藏失败！");
			}
		}
	}
	
	
}