<?php

/**
 * 个人中心
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;
use User\Model\MemberModel;

class MyController extends HomeBaseController {
	private $user;
	private $order_obj;
	public function _initialize(){
		parent::_initialize();
		if( !$_SESSION['user']['id'] ) $this->redirect(U('User/login/index'));
		$this->order_obj = D('Common/Order');
		$this->user = M('Member')->where( array("id"=>$_SESSION['user']['id']) )->find();
		$this->assign('user' , $this->user);
	}
	public function index(){
		$map = array(
			'user_id' => $this->user['id'],
			'user_status' => 0,
		);
		$result = $this->order_obj->getOrders(1 , $map);
		//我的账户
        $uid = $this->user['id'];
        $ac = M("Account");
        $acData = $ac->where("uid=$uid")->select();
        $this->assign("account",$acData[0]);
        //职位
        $jobCount = M("Jobs")->where("uid=$uid")->count();
        $this->assign("jobCount",$jobCount);
        //简历
        $resumeCount = M("Resume")->where("uid=$uid")->count();
        $this->assign("resumeCount",$resumeCount);
        $applyCount =  M("Apply")->where("uid=$uid")->count();
        $this->assign("applyCount",$applyCount);
        $this->display();
	}
	
	public function addAddress(){
		$data = I('post.');
		if( $data['address_id'] ){
			
		}else{
			if( M("Member_address")->where( array('member_id'=>$this->user['id']) )->count('address_id') >= 10 ) $this->error("最多只能创建10个收货地址");	
		}
		$data['member_id'] = $this->user['id'];
		if( !$data['consignee'] || !$data['country'] || !$data['address'] ) $this->error('失败,收货人,国家,收货地址为必填项');
		//$data['tel'] = $data['zonecode'].'-'.$data['telnum'].'-'.$data['telext'];
		$data['tel'] = ($data['zonecode']?$data['zonecode']:'').($data['telnum']?'-'.$data['telnum']:'').($data['telext']?'-'.$data['telext']:'');
		if( $data['is_default']==1 ){
			$status['is_default'] = 0;
			M("Member_address")->where( array('member_id'=>$this->user['id']) )->save($status);
		}
		if( !$data['address_id'] ){
			if( M('Member_address')->add($data) ){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			if( M('Member_address')->save($data) ){
				$this->success("修改成功");
			}else{
				$this->error('修改失败');
			}	
		}
	}
	
	public function setAdressDefault(){
		$data['is_default'] = 0;
		M('Member_address')->where( array('member_id'=>$this->user['id']) )->save($data);
		$data['address_id'] = I('get.id');
		$data['is_default'] = 1;
		if( M('Member_address')->save($data) ) 
			$this->success('设置成功');
		else
			$this->error('设置失败');
	}
	
	public function delAddress(){
		if( M('Member_address')->where( array('address_id'=>I('get.id'),'member_id'=>$this->user['id'] ) )->delete() )
			$this->success('删除成功');
		else
			$this->error('删除失败');
	}
	
	public function getRegion(){
		$dao=D("Region");
		$map['pid']=$_REQUEST["pid"];
		$map['type']=$_REQUEST["type"];
		$list=$dao->where($map)->select();//echo $list;die;
		echo json_encode($list);
	}
	
	public function points(){
		$count = M('Member_points')->where( array('member_id'=>$this->user['id']) )->count('id');
		$page = page($count , 3);
		$result = M('Member_points p')->join('left join '.C('DB_PREFIX')."order o on o.order_sn=p.order_sn")->where( array('p.member_id'=>$this->user['id'],'affected_type'=>array('in','1,2')) )->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('points' , $result);
		$this->assign('page' , $page->show());
		$page = page($count , 1);
		$this->display();
	}
	
	public function fav(){
		$count = M('Member_fav')->where( array('uid'=>$this->user['id']) )->count('id');
		$page = page($count , 1);
		$result = M('Member_fav f')->field("f.id,g.name,g.price,g.pricespe,g.id as gid,g.img_url")->join('left join '.C('DB_PREFIX')."goods g on g.id=f.goods_id")->where( array('f.uid'=>$this->user['id']) )->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('page' , $page->show());
		$this->assign( 'fav' , $result );
		$this->display();
	}
	
	public function addFav(){
		$id = I('get.id');
		if( !$id ) $this->error('不存在的商品');
		if( I('get.type')=='cart' ){
			M('Cart')->where( array('uid'=>$this->user['id'],'gid'=>$id ) )->delete();
		}
		if( !empty( M('Member_fav')->where( array('uid'=>$this->user['id'] , 'goods_id'=>$id) )->find() ) ) $this->error("您已收藏过此商品了");
		$data = array(
			'uid' => $this->user['id'],
			'goods_id' => $id,
			'add_time' => time(),
		);
		if( M('Member_fav')->add($data) )
			$this->success('添加收藏成功');
		else
			$this->error('添加收藏失败');
	}
	
	public function delFav(){
		$id = I('get.id');
		if( M('Member_fav')->where( array( 'uid'=>$this->user['id'] , 'id'=>$id ) )->delete() )
			$this->success("移除收藏夹成功");
		else
			$this->error("移除收藏夹失败");
	}

	public function profile(){
		$this->user = M('Member')->where( array( 'id'=>$this->user['id'] ) )->find();
		$this->user['birth'] = explode('-' , $this->user['birthday']);
		$this->assign( 'user' , $this->user );
		//var_dump($this->user);die;
		$this->display();
	}
	
	public function portrait(){
		$this->display();
	}
	
	public function address(){
		$this->assign( 'country' , M('Region')->where( array('type'=>0) )->select() );
		$address = M('Member_address')->where( array('member_id'=>$this->user['id']) )->select();
		foreach( $address as $k => $v ){
			$address_ids = $v['country'].','.$v['province'].','.$v['city'].','.$v['district'];
			$info = '';
			$info = M('Region')->where( array( 'id'=>array( 'in' , $address_ids ) ) )->select();
			$addr = '';
			foreach( $info as $value ){
				$addr .= ' '.$value['name'];
			}
			$address[$k]['addr'] = $addr;
		}
		$this->assign('address' , $address);
		$this->display();
	}
	
	public function getAddress(){
		$this->success(M('Member_address')->where( array('address_id'=>I('get.id')) )->find());
	}

    //修改密码
    function change_pwd(){
        if(IS_AJAX){
            if(!IS_POST){
                Utils::resOut(-1,'非法提交');
                exit();
            }
            if(!isset($_POST['oldpwd'])){
                Utils::resOut('-1','请输入旧密码');
                exit();
            }
            $oldpwd = $_POST['oldpwd'];
            if(strlen($oldpwd)<6 || strlen($oldpwd)>16){
                Utils::resOut(-1,'旧密码长度有误');
                exit();
            }
            if(!isset($_POST['newpwd'])){
                Utils::resOut('-1','请输入新密码');
                exit();
            }
            $newpwd = $_POST['newpwd'];
            if(strlen($newpwd)<6 || strlen($newpwd)>16){
                Utils::resOut(-1,'新密码长度有误');
                exit();
            }
            $renewpwd = $_POST['renewpwd'];
            if($renewpwd != $newpwd){
                Utils::resOut(-1,'两次密码不一致');
                exit();
            }
            $user = new MemberModel();
            $res = $user->change_pwd($oldpwd,$newpwd);

            if($res==-1){
                Utils::resOut(-1,'旧密码错误');
                exit();
            }
            Utils::resOut(0,'修改成功');

            exit();
        }
        $this->display();
    }
	//安全认证
    function user_verify(){
        $user = new MemberModel();
        $account = $user->audit_status($_SESSION['user']['id']);
        $this->assign("account",$account);
        $this->display();
    }
    //上传认证
    function upload_identify()
    {
        $uid = $_SESSION['user']['id'];
        $utype = $_SESSION['user']['utype'];
        $user = new MemberModel();
        $res = $user->audit_status($uid);
        $ustatus = $res['audit'];
        if($utype == 1){
            if($ustatus == 1){
                if($res['identify_z'] && $res['identify_f']) {
                    Utils::resOut('-1', '您提交的资料正在验证');
                    exit();
                }
            }
        }
        if($utype == 2){
            if($ustatus == 1){
                Utils::resOut('-1', '您提交的资料正在验证');
                exit();
            }
        }
        if($ustatus == 2){
            Utils::resOut('-1','您已经通过认证，无需在认证');
            exit();
        }

        if(!isset($_GET['act'])){
            Utils::resOut(-1,'非法访问1');
            exit();
        }elseif($_GET['act'] !='z' && $_GET['act']!='f' && $_GET['act']!='l'){
            Utils::resOut(-1,'非法访问2');
            exit();
        }
        $act = I('get.act');
        if($act == 'l' && $utype==1){
            Utils::resOut('-4','您是个人用户不能上传营业执照');
            exit();
        }
        if($act == 'z' || $act=='f' && $utype==2){
            if($utype==2) {
                Utils::resOut('-4', '您是企业用户不能上传身份证');
                exit();
            }
        }

        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array("jpg", "gif", "png", "jpeg");
        $upload->rootPath = "./data/upload/";
        $upload->savePath = "";
        $info = $upload->upload();
        if(!$info){
            Utils::resOut(-2,$upload->getError());
            exit();
        }
        $rootPath = substr($upload->rootPath,2);
        $img_path = $rootPath . $upload->savePath . "/" . $info['file']['savepath'] . $info['file']['savename'];
        //开始更新字段

        if($act == 'z'){
            $field = $img_path;
            $utype = 1;
        }elseif($act == 'f'){
            $data['identify_f'] = $img_path;
            $data['utype'] = 1;
        }else{
            $data['license'] = $img_path;
            $data['utype'] = 2;
        }
        $res = $user->identify($img_path,$act,$utype);
        if($res){
            Utils::resOut('0',$img_path);
            exit();
        }else{
            Utils::resOut('-3','更新失败，请重试');
            exit();
        }

    }


	public function test1(){
		freezePoints(100 , 111 , $_SESSION['user']['id'] , '冻结积分');
	}
	public function test2(){
		confirmFreezePoints(100 , 111 , $_SESSION['user']['id'] , '退还积分');
	}
	public function test3(){
		confirmFreezePoints(-100 , 111 , $_SESSION['user']['id'] , '确认消费');
	}
}
