<?php

namespace ArowPay;

use ArowPay\Initialize;

class IPN
{
    use Initialize;

    /**
     * Validate the IPN request and payment.
     *
     * @return bool
     */
    public function validate()
    {
        $raw=file_get_contents("php://input");
        $post=json_decode($raw,true);
        if($post===false){
               return false;
        }else{
            if(!isset($post['txid'],$post['currency'],$post['time'],$post['amount'])){
               return false;
            }
            if(!isset($_SERVER['HTTP_NONCE'],$_SERVER['HTTP_TIMESTAMP'],$_SERVER['HTTP_APPKEY'],$_SERVER['HTTP_SIGNATURE'])){
               return false;
            }
            $nonce=$_SERVER['HTTP_NONCE'];
            $timestamp=$_SERVER['HTTP_TIMESTAMP'];
            $appkey=$_SERVER['HTTP_APPKEY'];
            $signature=$_SERVER['HTTP_SIGNATURE'];
            $txid=$post['txid'];
            $currency=$post['currency'];
            $amount=$post['amount'];
            if(strcasecmp($appkey,$this->appkey)!=0){
               return false;
            }
            $localsignature=sha1($this->appsecret.$nonce.$timestamp.$txid.$amount.$currency);
            if(strcasecmp($localsignature,$signature)!=0){
               return false;
            }
            return true;

            
        }

        
    }



}
