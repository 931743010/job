<?php

/**
 * 配置文件
 */

return array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'job',
    'DB_USER' => 'root',
    'DB_PWD' => 'root',
    'DB_PORT' => '3306',
    'DB_PREFIX' => 'sp_',
    //密钥
    "AUTHCODE" => 'eGa2lBmFUJJI5Eqwqh',
    //cookies
    "COOKIE_PREFIX" => 'jfPcjV_',
	'REDIS_SERVER' => 'localhost',
	'REDIS_PORT' => 6379,
	'REDIS_PASS' => 'vsgame&2015',
	// Elasticsearch
	
    // 'SESSION_OPTIONS'=>array(
    // 'type'=> 'db',//session采用数据库保存
    // 'expire'=>1440,//session过期时间，如果不设就是php.ini中设置的默认值
    // ),
    // 'SESSION_TABLE'=>'sp_session', //必须设置成这样，如果不加前缀就找不到数据表，这个需要注意
		
);

?>