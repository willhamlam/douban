<?php

if(isset($_POST['action']) && $_POST['action'] === 'db_action'){
	
	$res = array();
	$url = $_POST['url'];
	$type = $_POST['type'];
	$data = array();
	$header = array(
		'Content_type: application/x-www-form-urlencoded'
	);

	if(isset($_POST['token']) && $_POST['token'] !== 'undefined'){
		$accessToken = $_POST['token'];
		$header[1] = 'Authorization: Bearer '.$accessToken;
	}
	if(isset($_POST['data'])){
		$data = $_POST['data'];
	}

	try{
		$res = curl($url, $type, $header, $data);
	}catch(Exception $e){
		$res = 'failed';
	}
	$test = array($url, $type, $header, $data);

	die(json_encode($res));
}

function curl($url, $type, $header, $data = null){
    $ch = curl_init();

    // 设置请求的URL链接
    curl_setopt($ch, CURLOPT_URL, $url);

    // 设置请求类型
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

    // 设置请求Header信息
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    // 跳过证书验证
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);

    // 返回响应内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // 传递POST或PUT请求数据
    if ($type == 'POST' || $type =='PUT') {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);            
    }

    $result = curl_exec($ch);

    curl_close($ch);  
    
    // 返回Decode之后的数据
    return $result = json_decode($result);
}