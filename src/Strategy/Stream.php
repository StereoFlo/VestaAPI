<?php

namespace VestaManage\Strategy;

/**
 * Class Stream
 * @package VestaManage\Strategy
 */
class Stream extends StrategyAbstract
{

    /**
     * @return mixed
     */
    protected function get()
    {
        $options = [
            'http' => [
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n" . "Content-Length: " . \mb_strlen($this->postString) . "\r\n",
                'content' => $this->postString,
            ],
        ];

        if (!$this->sslVerify) {
            $options = $options + [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
            ];
        }
        $context = \stream_context_create($options);
        $data = \file_get_contents($this->url, false, $context);
        if (empty($data)) {
            return '';
        }
        return $data;
    }

    /**
     * @return self
     */
    public static function create()
    {
        return new self();
    }
}