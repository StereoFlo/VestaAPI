<?php

namespace VestaManage\Services;


interface StrategyInterface
{
    /**
     * @return self
     */
    public static function create();

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function setUrl($url);

    /**
     * @param array $postString
     *
     * @return self
     */
    public function setPostString($postString);

    /**
     * @param int $timeout
     *
     * @return self
     */
    public function setTimeout($timeout);

    /**
     * @param bool $sslVerify
     *
     * @return self
     */
    public function setSslVerify($sslVerify);

    /**
     * @return string
     */
    public function getRaw();

    /**
     * @return array
     */
    public function getArray();
}