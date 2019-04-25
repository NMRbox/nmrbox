<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-Auth-Token, X-CSRF-TOKEN, X-XSRF-TOKEN, Authorization');

$params = json_decode(file_get_contents('php://input'),true);

$site_url = 'http://nmrbox.dev';
//$site_url = 'https://webdev.nmrbox.org:8001';
$url = '';

if(isset($params['request_type']) && $params['request_type'] == 'signin') {
    $url = $site_url . '/'. $params['request_type'];
    unset($params['request_type']);
}
if(isset($params['request_type']) && $params['request_type'] == 'signup') {
    $url = $site_url . '/'. $params['request_type'];
    unset($params['request_type']);
}

if(empty($url)) {
    die('Request type is not set!');
}

/* CURL request */
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
//curl_setopt($ch, CURLOPT_PORT, 8001);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS,
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);
//var_dump($server_output);
$decode = json_decode($server_output);
//var_dump($decode);


if(isset($decode->success)) {
    echo json_encode(array('status'=>200,'message'=>'success','person_id' => $decode->person_id, 'notification'=>$decode->success, 'token' => $decode->token, 'session' => $decode->session));
} else {
    echo json_encode(array('status'=>401,'message'=>'fail', 'notification'=> ($decode->error ? $decode->error : '')));
}