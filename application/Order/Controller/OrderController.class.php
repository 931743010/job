<?php

/**
 * 搜索结果页面
 */
namespace Order\Controller;
use Common\Controller\HomeBaseController;
use Order\Controller\AlipayController as Alipay;
use Order\Controller\AlipayNotifyController as AlipayNotify;
class OrderController extends HomeBaseController {
	private $user;
	protected $alipay_config = array(
		'partner'	=> '2088021359866822',

		//收款支付宝账号
		'seller_email'	=> '3270910200@qq.com',

		//安全检验码，以数字和字母组成的32位字符
		'key'			=> 'mn9ru925i35st9ug4xy4jhlko7ksg7uz',

		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑

		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		'transport'    => 'http',
	);



	public function _initialize(){
		if( !$_SESSION['user']['id'] ) $this->redirect(U('User/login/index'));
		$this->user = $_SESSION['user'];
		parent::_initialize();
		//签名
		$this->alipay_config['sign_type'] = strtoupper('MD5');
		//字符
		$this->alipay_config['input_charset'] = strtolower('utf-8');
		//证书
		$this->alipay_config['cacert'] = getcwd().'\\cacert.pem';

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
        $notify_url = "http://www.rengongonline.com/index.php/Order/order/notify_url";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://www.rengongonline.com/index.php/Order/order/return_url";
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


		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($this->alipay_config['partner']),
				"seller_email" => trim($this->alipay_config['seller_email']),
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
				"_input_charset"	=> trim(strtolower($this->alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new Alipay($this->alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "没跳转点此");
		echo $html_text;
	}


	function pay1(){
		//dump($_SERVER);
		// $this->display();
		//$this->success("sss","http://www.hmv.com/index.php/?g=portal");
	}
	/*
	*支付回调
	*/
	function notify_url(){

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($this->alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代

			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号

			$out_trade_no = I('post.out_trade_no');

			//支付宝交易号

			$trade_no = $_POST['trade_no'];

			//交易状态
			$trade_status = $_POST['trade_status'];

			$where['order_sn'] = $out_trade_no;
			$order = M("Order");

		    if($_POST['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		    	$up['pay_status']=2;
		    	
		    	$data = $order->where($where)->find();
		    	if(!$data){
		    		$this->error("订单号不存在");
		    		exit();
		    	}
		    	if($data['pay_status'] ==2){
		    		exit();
		    	} 
		    	$up['order_status'] = 2 ;
		    	$order->where($where)->save($up);

		    	exit();


		    }
		    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

				// $trade_no
				$data = $order->where($where)->find();
				if(!$data){
					$this->error("验证失败，请重新支付",$_SERVER['HTTP_HOST']."/index.php/?g=Order&m=order&a=pay");
					exit();
				}
				if($data['pay_status!=0']){
					exit();
				}
				$up['pay_status']=1;
				$up['pay_time'] = time();
				$order->where($where)->save($up);
				//新增金额
				$uid = $_SESSION['user']['id'];
				M("Account")->where("uid=$uid")->setInc("money",$data['money']);
				$this->success("付款成功",$_SERVER['HTTP_HOST']."/index.php/?g=user&m=account&a=index");
				exit();

		    }

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		        
			// echo "success";		//请不要修改或删除
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    $this->error("验证失败，请重新支付",$_SERVER['HTTP_HOST']."/index.php/?g=Order&m=order&a=pay");
		    exit();

		    //调试用，写文本函数记录程序运行情况是否正常
		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}

	function return_url(){

	
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($this->alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代

			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号

			$out_trade_no = I('get.out_trade_no');

			//支付宝交易号

			$trade_no = $_GET['trade_no'];

			//交易状态
			$trade_status = $_GET['trade_status'];

			$where['order_sn'] = $out_trade_no;
			$order = M("Order");

		    if($_GET['trade_status'] == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		    	$up['pay_status']=2;
		    	
		    	$data = $order->where($where)->find();
		    	if(!$data){
		    		$this->error("订单号不存在");
		    		exit();
		    	}
		    	if($data['pay_status'] ==2){
		    		exit();
		    	} 
		    	$up['order_status'] = 2 ;
		    	$order->where($where)->save($up);
		    	exit();


		    }
		    else if ($_GET['trade_status'] == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//付款完成后，支付宝系统发送该交易状态通知

		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

				// $trade_no
				$data = $order->where($where)->find();
				if(!$data){
					$this->error("验证失败，请重新支付",U('Order/order/pay'));
					exit();
				}
				if($data['pay_status!=0']){
					exit();
				}
				$up['pay_status']=1;
				$up['pay_time'] = time();
				$order->where($where)->save($up);
				//新增金额
				$uid = $_SESSION['user']['id'];
				M("Account")->where("uid=$uid")->setInc("money",$data['money']);
				$this->success("付款成功",$_SERVER['HTTP_HOST']."/index.php/?g=user&m=account&a=index");
				exit();
		    }

			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		        
			// echo "success";		//请不要修改或删除
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    $this->error("验证失败，请重新支付",$_SERVER['HTTP_HOST']."/index.php/?g=Order&m=order&a=pay");
		    dump($_REQUEST);
		    exit();

		    //调试用，写文本函数记录程序运行情况是否正常
		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}























}
