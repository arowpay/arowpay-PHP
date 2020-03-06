<?php

namespace ArowPay;

trait Initialize
{
    private $appkey = '';
    private $appsecret = '';

    /**
     * Set the appkey.
     *
     * @param  string  $appKey
     * @return self
     */
    public function setAppkey($appkey)
    {
        $this->appkey = $appkey;

        return $this;
    }

    /**
     * Set the appsecret.
     *
     * @param  string  $appsecret
     * @return self
     */
    public function setAppsecret($appsecret)
    {
        $this->appsecret = $appsecret;

        return $this;
    }
}
