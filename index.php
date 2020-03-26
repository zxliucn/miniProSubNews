<?php

$code=$_GET['js_code'];

$oopenId=getOpenId($code);
$accessToken=getAccessToken();

$url="https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=".$accessToken;
$query_data = [
            'access_token' =>getAccessToken(),
            'touser' => $oopenId['openid'],
            'template_id' => 'j4nhysEoxCOBoW9F8NUyzYZzlIhnvtgGyLVE32swccY',
            'page' => 'pages/index/index',
            'data' => [
                'thing1' => ["value" => "C语言程序设计"],
                'time5' => ["value" => "10:20"],
                'thing6' => ["value" => "教三-201"],
                'thing7' => ["value" => "2.1 变量的定义"],
                'name10' => ["value" => "张三"]
            ]
        ];

  $res=httpPost($url,json_encode($query_data));

  jsonReturn("1",'aaa',array(
    'jscode'=>$code,
    'accessToken'=>$accessToken,
    'openid'=>$oopenId,
    'res'=>$res
  ));
  


/***********************************************************/
  function jsonReturn($code = 200,$msg='',$data = null)
    {
        $Result['code'] = $code;
        $Result['msg'] = $msg ? $msg : '';
        if($data !== null) $Result['data'] = $data;
        if(($Result = json_encode($Result,JSON_UNESCAPED_UNICODE)) === false){
            switch(json_last_error()){
                case JSON_ERROR_NONE: exit('JSON_ERROR_NONE');
                case JSON_ERROR_DEPTH: exit('JSON_ERROR_DEPTH');
                case JSON_ERROR_STATE_MISMATCH: exit('JSON_ERROR_STATE_MISMATCH');
                case JSON_ERROR_CTRL_CHAR: exit('JSON_ERROR_CTRL_CHAR');
                case JSON_ERROR_SYNTAX: exit('JSON_ERROR_SYNTAX');
                case JSON_ERROR_UTF8: exit('JSON_ERROR_UTF8');
                case JSON_ERROR_RECURSION: exit('JSON_ERROR_RECURSION');
                case JSON_ERROR_INF_OR_NAN: exit('JSON_ERROR_INF_OR_NAN');
                case JSON_ERROR_UNSUPPORTED_TYPE: exit('JSON_ERROR_UNSUPPORTED_TYPE');
                case JSON_ERROR_INVALID_PROPERTY_NAME: exit('JSON_ERROR_INVALID_PROPERTY_NAME');
                case JSON_ERROR_UTF16: exit('JSON_ERROR_UTF16');
                default: exit('JSON_ERROR_UNKNOWN');
            }
        }
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        //跨域请求
        //header('Access-Control-Allow-Origin:*');
        exit($Result);
    }


  function getAccessToken(){
    $appid="wx8e5589d71d8f9e67";
    $appsecret = "69525714************b8ebbdcd9";
    $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
    $res=json_decode(httpGet($url),true);  
    return $res['access_token']; 
  }

  function getOpenId($code){
    $appid="wx8e5589d71d8f9e67";
    $appsecret = "695257148************8ebbdcd9";
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$code.'&grant_type=authorization_code';
    $res=json_decode(httpGet($url),true); 
    return $res;
  }        
   
 

  //公共的curl方法
  function httpGet($url){
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    //如果用的是https，ssl安全验证
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    $res =curl_exec($curl);
    curl_close($curl);
    return $res;
  }
  function httpPost($url, $data) {
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_TIMEOUT, 10);
   $output = curl_exec($ch);
   curl_close($ch);
   return $output;
}

?>
