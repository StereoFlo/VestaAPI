<?php

namespace VestaManage\Facades;

use Illuminate\Support\Facades\Facade;
use VestaManage\Services\VestaManage;

class Vesta extends Facade
{
    /**
     * @return VestaManage
     */
    protected static function getFacadeAccessor()
    {
        return VestaManage::class;
    }
}
