<?php

return [
    // value can be 'curl' or 'stream'
    // curl - request will be made with curl function
    // stream  - request will be made with streams
    'strategy' => 'curl',
    'servers' => [
        'testVDS' => [
            'host'  => '0.0.0.0',
            'admin' => 'admin',
            'key'   => 'secretString',
        ],
    ],

];