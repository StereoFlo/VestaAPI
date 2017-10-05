<?php

namespace VestaAPI\Facades;

use Illuminate\Support\Facades\Facade;
use VestaAPI\Services\VestaAPI;

class Vesta extends Facade
{
    /**
     * @return VestaAPI
     */
    protected static function getFacadeAccessor()
    {
        return VestaAPI::class;
    }
}
