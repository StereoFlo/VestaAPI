<?php

namespace VestaManage\Services;


use VestaManage\Strategy\StrategyAbstract;

class Curl extends StrategyAbstract
{
    /**
     * for static call
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @return mixed
     */
    protected function get()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postString);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        if (!$this->sslVerify) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}