<?php
$db = require( DIR_WEBSOCKET."/../../data/conf/db.php");
/**
* 
*/
class DB
{
	static $_instance = null;
	private $conn =null;
	private function __construct(){

	}
	public static function get_instance(){
		if(self::$_instance==null){
			return new self;
		}else{
			return self::$_instance;
		}
	}
	//连接数据库
	function connect($host,$user,$pwd,$db_name){
		if(!$this->conn){
			$this->conn = mysql_connect($host,$user,$pwd) or die('mysql error');
			mysql_query("set names utf8");
			mysql_select_db($db_name);
		}
	}

//查询
function query($sql){
	$res = mysql_query($sql);
	$arr = array();
	while ($row = mysql_fetch_assoc($res)) {
		$arr[] = $row;
	}
	return $arr;
}

//新增
function add($sql){
	$res = mysql_query($sql);
	if($res){
		return mysql_insert_id();
	}
	return 0;
}
//更新
	
}



?>