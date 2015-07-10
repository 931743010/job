<?php
namespace Goods\Controller;
use Common\Controller\AdminbaseController;
class AdminCateController extends AdminbaseController {
	
	protected $goodscat_obj;
	
	protected $taxonomys=array("article"=>"商品","picture"=>"图片");
	function _initialize() {
		parent::_initialize();
		$this->goodscat_obj = D("Common/Cate");
		$this->assign("taxonomys",$this->taxonomys);
	}
	function index(){
		$result = $this->goodscat_obj->order(array("listorder"=>"asc"))->select();
		
       /*  $tree = new PathTree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '---';
       	$tree->init($result);
       	$tree=$tree->get_tree();
       	$this->assign("terms",$tree); */
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("AdminCate/add", array("parent" => $r['id'])) . '">添加子类</a> | <a href="' . U("AdminCate/edit", array("id" => $r['id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AdminCate/delete", array("id" => $r['id'])) . '">删除</a> ';
			$url=U('portal/list/index',array('id'=>$r['id']));
			$r['url'] = $url;
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['id'];
			$r['parentid']=$r['parent'];
			$array[] = $r;
		}
		
		$tree->init($array);
		$str = "<tr>
					<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td>\$id</td>
					<td>\$spacer <a href='\$url' target='_blank'>\$name</a></td>
					<td align='center'><a href='\$url' target='_blank'>访问</a></td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
        //$this->display();
	}
	
	
	function add(){
	 	$parentid = intval(I("get.parent"));
	 	$tree = new \PathTree();
	 	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
	 	$tree->nbsp = '---';
	 	$result = $this->goodscat_obj->order(array("path"=>"asc"))->select();
	 	$tree->init($result);
	 	$tree=$tree->get_tree();
	 	$this->assign("terms",$tree);
	 	$this->assign("parent",$parentid);
	 	$this->display();
	}
	
	function add_post(){
		if (IS_POST) {
			if ($this->goodscat_obj->create()) {
				if ($this->goodscat_obj->add()!==false) {
					$this->success("添加成功！",U("AdminCate/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->goodscat_obj->getError());
			}
		}
	}
	
	function edit(){
		$id = intval(I("get.id"));
		$tree = new \PathTree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '---';
		$result = $this->goodscat_obj->where(array("id" => array("NEQ",$id), "path"=>array("notlike","%-$id-%")))->order(array("path"=>"asc"))->select();
		$tree->init($result);
		$tree=$tree->get_tree();
		
		$data=$this->goodscat_obj->where(array("id" => $id))->find();
		$this->assign("terms",$tree);
		$this->assign("data",$data);
		$this->display();
	}
	
	function edit_post(){
		if (IS_POST) {
			if ($this->goodscat_obj->create()) {
				if ($this->goodscat_obj->save()!==false) {
					$this->success("修改成功！");
				} else {
					$this->error("修改失败！");
				}
			} else {
				$this->error($this->goodscat_obj->getError());
			}
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::_listorders($this->goodscat_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	/**
	 *  删除
	 */
	public function delete() {
		$id = intval(I("get.id"));
		$count = $this->goodscat_obj->where(array("parent" => $id))->count();
		if ($count > 0) {
			$this->error("该菜单下还有子类，无法删除！");
		}
		if ($this->goodscat_obj->delete($id)!==false) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	/* public function show(){
		$result = $this->goodscat_obj->order(array("listorder"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['id'];
			$r['parentid']=$r['parent'];
			$name=$r['name'];
			$url=U('post/lists',array('term'=>$r['id']));
			$r['name']="<a class='term_link' href='$url' >$name</a>";
			$array[$r['id']] = $r;
		}
		$str = "<tr>
				<td >\$spacer\$name</td>
				</tr>";
		$tree->init($array);
		
		$categorys = $tree->get_tree(0, $str);;
			
		$this->assign("categorys", $categorys);
		$this->display();
	} */
}