<?php

namespace VestaManage\Services;

use VestaManage\Exceptions\VestaExceptions;
use VestaManage\Strategy\StrategyAbstract;
use VestaManage\Strategy\Curl;
use VestaManage\Strategy\Stream;

class VestaManage
{
    use Db, Dns, User, Web, Service, Cron, FileSystem;

    const RETURN_CODE_YES = 'yes',
          RETURN_CODE_NO = 'no';

    const POSITION_TYPE        = 0;
    const POSITION_PERMISSIONS = 1;
    const POSITION_DATE        = 2;
    const POSITION_TIME        = 3;
    const POSITION_OWNER       = 4;
    const POSITION_GROUP       = 5;
    const POSITION_SIZE        = 6;
    const POSITION_NAME        = 7;

    const FILESYSTEM_DELIMITER = '|';

    const STRATEGY_STREAM = 'stream';
    const STRATEGY_CURL = 'curl';

    /**
     * @var string
     */
    private $adminUserName = '';

    /**
     * @var string
     */
    private $userName = '';

    /**
     * return no|yes|json.
     *
     * @var string
     */
    private $returnCode = 'yes';

    /**
     * @var string
     */
    private $key = '';

    /**
     * @var
     */
    private $host = '';

    /**
     * @var bool
     */
    private $toArray = false;

    /**
     * @var StrategyAbstract
     */
    private $strategy;

    /**
     * VestaManage constructor.
     */
    public function __construct()
    {
        $strategy = config('vesta.strategy');
        switch ($strategy) {
            case self::STRATEGY_CURL:
                $this->strategy = Curl::create();
                break;
            case self::STRATEGY_STREAM:
                $this->strategy = Stream::create();
                break;
        }
        if (\is_null($this->strategy)) {
            throw new \Exception('Strategy is not specify');
        }
    }

    /**
     * @param string $server
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function server($server = '')
    {
        if (empty($server)) {
            throw new \Exception('Server is not specified');
        }
        $allServers = config('vesta.servers');

        if (!isset($allServers[$server])) {
            throw new \Exception('Specified server not found in config');
        }

        if ($this->keysCheck($server, $allServers)) {
            throw new \Exception('Specified server config does not contain host or key');
        }

        $this->key           = $allServers[$server]['key'];
        $this->host          = $allServers[$server]['host'];
        $this->adminUserName = $allServers[$server]['admin'];

        return $this;
    }

    /**
     * @param string $server
     * @param array  $config
     *
     * @return bool
     */
    private function keysCheck($server, $config)
    {
        return !isset($config[$server]['key']) || !isset($config[$server]['host']);
    }

    /**
     * @param string $userName
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setUserName($userName = '')
    {
        if (empty($userName)) {
            throw new \Exception('User is not specified');
        }
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @param string $returnCode
     *
     * @return self
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
        return $this;
    }

    /**
     * @param bool $toArray
     *
     * @return self
     */
    public function setToArray($toArray)
    {
        $this->toArray = $toArray;
        return $this;
    }

    /**
     * @param string $cmd
     *
     * @return StrategyAbstract
     * @throws VestaExceptions
     */
    public function send($cmd)
    {
        $postVars = [
            'user'       => $this->adminUserName,
            'hash'       => $this->key, // api key
            'returncode' => $this->returnCode,
            'cmd'        => $cmd,
        ];
        $args = func_get_args();
        foreach ($args as $num => $arg) {
            if ($num === 0) {
                continue;
            }
            $postVars['arg' . $num] = $args[$num];
        }

        $query = $this->strategy
            ->setUrl('https://' . $this->host . ':8083/api/')
            ->setPostString($postVars)
            ->setTimeout(10);

        if ($this->getReturnCode() === 'yes' && $query !== 0) {
            throw new VestaExceptions($query);
        }
        return $query;
    }

    /**
     * @param StrategyAbstract $sender
     *
     * @return mixed
     */
    public function toString(StrategyAbstract $sender)
    {
        return $sender->getRaw();
    }

    /**
     * @param StrategyAbstract $sender
     *
     * @return array
     */
    public function toArray(StrategyAbstract $sender)
    {
        return $sender->getArray();
    }
}
