<?php
/**
 * Created by PhpStorm.
 * User: yqbaa
 * Date: 15-7-2
 * Time: 下午10:21
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
use Common\Controller\UtilsController as Utils;
use User\Model\MemberModel;

class AccountController extends HomeBaseController
{
    private $user;
    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
    }
    /*
    我的余额
    */
    function index(){
        $ac = M("Account");
        $data = $ac->where("uid = ".$this->user['id'])->find();
        // dump($data);
        if(!$data){
            $this->error('系统无此数据');
            exit();
        }
        $this->assign("account",$data);
        $this->display();

    }





}