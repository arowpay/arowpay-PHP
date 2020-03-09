<?php

namespace ArowPay;

use ArowPay\Initialize;

class API
{
    use Initialize;


    public function execute($command ,array $fields = [])
    {
        // Define the API url
        $api_url = 'https://api.arowpay.io/'.$command;
        $httpHeader = $this->createHttpHeader();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); //处理http证书问题
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        // if (false === $ret) {
        //     $ret =  curl_errno($ch);
        // }
        curl_close($ch);
        $result = json_decode($ret,true);
        if(!isset($result['code'])){
            $result=[];
            $result['code']="550";
            $result['msg']="unexpeted api call";
        }
        return $result;
    }

     private function createHttpHeader() {
        $nonce = mt_rand();
        $timeStamp = time();
        $sign = sha1($this->appsecret.$nonce.$timeStamp);
        return [
            'appkey:'.$this->appkey,
            'nonce:'.$nonce,
            'timestamp:'.$timeStamp,
            'signature:'.$sign,
            'Content-Type:application/x-www-form-urlencoded',
        ];
    }
}
