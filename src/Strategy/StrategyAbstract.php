<?php

namespace VestaManage\Strategy;

use VestaManage\Services\StrategyInterface;

/**
 * Class StrategyAbstract
 * @package VestaManage\Strategy
 */
abstract class StrategyAbstract implements StrategyInterface
{
    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $postString = '';

    /**
     * @var int
     */
    protected $timeout = 0;

    /**
     * @var bool
     */
    protected $sslVerify = false;

    /**
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param array $postString
     *
     * @return self
     */
    public function setPostString($postString)
    {
        $this->postString = http_build_query($postString);
        return $this;
    }

    /**
     * @param int $timeout
     *
     * @return self
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @param bool $sslVerify
     *
     * @return self
     */
    public function setSslVerify($sslVerify)
    {
        $this->sslVerify = $sslVerify;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->get();
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->toArray($this->get());
    }

    /**
     * @return mixed
     */
    abstract protected function get();

    /**
     * @param $json
     *
     * @return mixed
     */
    protected function toArray($json)
    {
        if (empty($json)) {
            return [];
        }
        return json_decode($json, true);
    }
}