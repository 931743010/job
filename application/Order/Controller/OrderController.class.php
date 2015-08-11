<?php

/**
 * 搜索结果页面
 */
namespace Order\Controller;
use Common\Controller\HomeBaseController;
use Order\Controller\AlipayController as Alipay;
class OrderController extends HomeBaseController {
	private $user;
	public function _initialize(){
		if( !$_SESSION['user']['id'] ) $this->redirect(U('User/login/index'));
		$this->user = $_SESSION['user'];
		parent::_initialize();
	}
	
	function pay(){
		$this->display();
	}
	/*
	去付款
	*/
	function gopay(){
		//支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://www.rengongonline.com/pay/notify_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://www.rengongonline.com/pay/return_url.php";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/


        if(!isset($_POST['WIDtotal_fee'])){
        	$this->error("请输入正确的充值金额",U("Order/order/pay"));
        	exit();
        }
        //付款金额
        $total_fee = $_POST['WIDtotal_fee'];
        if(!is_numeric($total_fee) || $total_fee<10){
        	$this->error("充值金额必须是大于10元",U("Order/order/pay"));
        	exit();
        }

		$data['money'] = $total_fee;
        //商户订单号
        
        $out_trade_no = $data['order_sn'] = date("YmdHis").mt_rand(0,20000).mt_rand(20000,40000);
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject =$data['subject']="{ ".$this->user['user_login'].' }在线充值';
        
        //必填

        //订单描述
        $body =$data['body']= $subject;
        
        $data['add_time']= time();
        $data['user_id'] = $this->user['id'];
        M("Order")->add($data);
        //商品展示地址
        $show_url = 'http://www.rengongonline.com';
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = "";
        //非局域网的外网IP地址，如：221.0.0.1
       

/************************************************************/

		
		//合作身份者id，以2088开头的16位纯数字
		$alipay_config['partner']		= '2088021359866822';

		//收款支付宝账号
		$alipay_config['seller_email']	= '3270910200@qq.com';

		//安全检验码，以数字和字母组成的32位字符
		$alipay_config['key']			= 'mn9ru925i35st9ug4xy4jhlko7ksg7uz';


		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


		//签名方式 不需修改
		$alipay_config['sign_type']    = strtoupper('MD5');

		//字符编码格式 目前支持 gbk 或 utf-8
		$alipay_config['input_charset']= strtolower('utf-8');

		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		$alipay_config['cacert']    = getcwd().'\\cacert.pem';

		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		$alipay_config['transport']    = 'http';

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"seller_email" => trim($alipay_config['seller_email']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new Alipay($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "没跳转点此");
		echo $html_text;
	}


	function pay1(){
		$this->display();
	}
}
