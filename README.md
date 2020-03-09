# ArowPay.com PHP API Wrapper.
# Introduction
ArowPay-PHP is a simple PHP package that lets you easily call APIs and  handle IPN requests from arowpay.com, without any hassle.


# Usage

First of all, install the package via Composer:

```sh
composer require arowpay/arowpay-php


```

Authenticating IPNs:

```php
<?php
require_once './vendor/autoload.php';
use ArowPay\IPN;

$ipn=new IPN();
$ipn->setAppkey('1Zf5Q28U2a5gmt367GQcbSCl35')->setAppsecret('nG8Pp15i8eWyE7tpDfpPr2D5326A7JfY8Ds3CqKqf5');

    if ($ipn->validate()) {
        // validated  
        $rawData=file_get_contents("php://input");
        $post=json_decode($rawData);
        $currency=$post['currency'];  //USDTERC20
        $amount=$post['amount']; //69
        $transactionId=$post['txid']; //0xbd31c2c70c67414d1ab5b591e436e318557dc37ca01bb18be8d81e6f83d84f0f
        $timestamp=$post['time']; // 1583504556
        $address=$post['address']; // 0xc9cb4be4687319a6421dac93df2604b8e309ad04
        $myCustomString=$post['custom']; // your custom string
        //process it


        die("OK");

    } else {
        //invalid request
    }
```

Call APIs:

```php
<?php
require_once './vendor/autoload.php';
use ArowPay\API;
//getCallbackAddress
$api=new API();
$api->setAppkey('1Zf5Q28U2a5gmt367GQcbSCl35')->setAppsecret('nG8Pp15i8eWyE7tpDfpPr2D5326A7JfY8Ds3CqKqf5');
$fields=array('currency'=>'BTC','custom'=>'CustomStrings');
$response=$api->execute("getCallbackAddress",$fields);
if($response['code']="200"){
     // successfully get an address
    $newAddress=$response['msg'];
    echo $newAddress; //1AEgdWjJrEbroURgWmPrXkFdzxGxdF7c4G

}else{
    echo $response['code'];
    echo $response['msg'];
}
```

