<?php
/*
 * 此控制器为文件上传操作管理控制器
* @author zhangzhiqiang <zhangzhiqiang@vsoyou.com>
*
*  */
namespace Order\Controller;
use Common\Controller\HomeBaseController;

class UploadController extends HomeBaseController {
	/*
	 * 
	 * 评价上传图片(后期统一)
	 * 
	 * */
	public function upload() {
		//图片上传处理类
            $config=array(
            		'rootPath' => './'.C("UPLOADPATH"),
            		'savePath' => 'comment/',
            		'maxSize' => 11048576,
            		'saveName'   =>    array('uniqid',''),
            		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
            		'autoSub'    =>    true
            );
			$upload = new \Think\Upload($config);// 
			$info=$upload->upload();
			if( $info ){//上传成功
				$first=array_shift($info);
				$bigimg = $first['savepath'] . $first['savename'];                
                $image = new \Think\Image();
                $srcimg = $upload->rootPath . $bigimg;
                $image->open( $srcimg );
                $image->thumb( 68, 68 , \Think\Image::IMAGE_THUMB_FILLED);
                $smallimg = $first['savepath'] . 'small_' . $first['savename'];
                $image->save($upload->rootPath.$smallimg);
                $this->ajaxReturn(array('error' => 0, 'smallimg' => C("TMPL_PARSE_STRING.__UPLOAD__") . $smallimg));
                exit;
			}
			$this->ajaxReturn(array('error' => 1, 'msg' => $upload->getError()));
			exit;
			
	}
}