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

class ChatController extends HomeBaseController
{
    private $user;
    private $apply_obj;

    public function _initialize()
    {
        parent::_initialize();
        if (!$_SESSION['user']['id']) $this->redirect(U('User/login/index'));
        $this->user = M('Member')->where(array("id" => $_SESSION['user']['id']))->find();
        $this->assign('user', $this->user);
//        $this->apply_obj = M("Apply");
    }
   function chat(){
      if(isset($_GET['rid'])){
          $rid = intval($_GET['rid']);
          $rdata = M("Member")->find($rid);
          if(!$rdata){
            $this->error('页面不存在');
            exit();
          }
      }

      //读取会话列表
      $prefix = C("DB_PREFIX");
      $uid = $_SESSION['user']['id'];
      $sql = "select * from {$prefix}chat where FIND_IN_SET({$uid},box_id)!=0 and FIND_IN_SET({$uid},close_id)=0 group by box_id";
      $data = M()->query($sql);
      // dump($data);
      $this->display();
   }

   //删除会话----暂时不做
   function delete_chat(){
      if(IS_POST && IS_AJAX){
          if(!isset($_POST['box_id'])){
            Utils::resout(-1,'参数错误');
            exit();
          }
          if(!Utils::isLegalValueList($_POST['box_id'])){
            Utils::resout(-1,'参数错误');
            exit();
          }
          $box_id = I('post.box_id');
          $box_arr = explode(',', $box_id);
          if(!in_array($uid, $box_id)){
              Utils::resout(-1,'参数错误');
              exit();
          }
          //开始更新
          $uid = $_SESSION['user']['id'];
          // $sql = "update sp_chat set close_id = contact(close,',',{$uid}) where box_id='{$box_id}'";
          $sql = "update sp_chat set close_id = CONCAT(close_id,',',{$uid}) where box_id = '{$box_id}' and close_id!=0";
          M()->execute($sql);
          $sql = "update sp_chat set close_id = {$uid} where box_id = '{$box_id}' and close_id=0";
          M()->execute($sql);
          Utils::resout(0,'删除成功');
          exit();

      }
   }

}

?>