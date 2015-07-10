<?php 
	$url = 'http://www.test.com/v1/order/read_post.json';
	$data['value'] = '{"pay_id":5,"consignee":"\u5f20\u6768","shipping_id":10,"country":1,"province":15,"city":22,"district":88,"address":"\u4e1c\u65b9\u79d1\u6280\u5927\u53a61901\u5ba4","goods":[{"goods_id":1,"num":1,"attr":"\u767d\u8272"},{"goods_id":2,"num":2,"attr":"\u9ed1\u8272"},{"goods_id":3,"num":3,"attr":""}]}';
	$data['access_token'] = '2.00e0ksbjooszatls94uf7b54fjhoevg1';
	$res = postMethod($data , $url);
	echo '<pre>';
	var_dump($res);
	echo '</pre>';
	
	function postMethod($data,$url)
	{
		$ch = curl_init();
		$res= curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		$result = curl_exec ($ch);
		curl_close($ch);
		if ($result == NULL) {
			return 0;
		}
		return $result;
	} 