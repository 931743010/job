<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MainController extends AdminbaseController {
	
	function _initialize() {
	}
    public function index(){
		$gdinfo = gd_info();
    	//服务器信息
    	$info = array(
			os => PHP_OS,
			ip => $_SERVER['SERVER_ADDR'],
			web_server => $_SERVER['SERVER_SOFTWARE'],
			php_ver => PHP_VERSION,
			mysql_ver => mysql_get_server_info(),
			zlib => function_exists('gzclose') ? 'yes':'no',
			safe_mode => (boolean) ini_get('safe_mode') ?  'yes':'no',
			safe_mode_gid => (boolean) ini_get('safe_mode_gid') ? 'yes' : 'no',
			timezone => function_exists("date_default_timezone_get") ? date_default_timezone_get() : 'no_timezone',
			socket => function_exists('fsockopen') ? 'yes' : 'no',
			'upload_limit' => ini_get('upload_max_filesize'),
			'version' => '1.0',
			'gd' => $gdinfo["GD Version"],
			'encode' => 'UTF-8',
			'install_date' => date('Y-m-d',filemtime('./install/install.lock')),
    	);
		if($gdinfo['GIF Read Support']) $info['gd'] .= ' gif';
		if($gdinfo['JPEG Support']) $info['gd'] .= ' | jpg';
		if($gdinfo['PNG Support']) $info['gd'] .= ' | png';
    	$this->assign('server_info', $info);
		//订单
    	$order = M("Order");
    	$prefix = C("DB_PREFIX");
    	$order_info['total'] = $order->count();
    	$order_info['pay_success_total'] = $order->where("pay_status = 1")->count();

    	$order_info['pay_fail_total'] = $order->where("pay_status = 0")->count();
    	$total_money = $order->field("sum(money) as total_money")->select();
    
    	$order_info['total_money'] = $total_money[0]['total_money'];
 
    	//职位
    	$job = M("Jobs");
    	$job_info['total'] = $job->count();
    	$job_info['total_success'] = $job->where('status=2')->count();
    	$job_info['total_fail'] = $job->where('status=3')->count();
    	$job_info['total_wait'] = $job->where('status=0')->count();

    	//会员
    	$member = M("Member");
    	$member_info['total'] = $member->count();
    	$member_info['total_company'] = $member->where("utype=2")->count();
    	$member_info['total_person'] = $member->where("utype=1")->count();

    	$this->assign("order",$order_info);
    	$this->assign("job",$job_info);
    	$this->assign("member",$member_info);

    	$this->display();
    }
}