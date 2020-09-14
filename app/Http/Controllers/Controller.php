<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BasisController;
use Illuminate\Support\Facades\DB;
use Log;

class Controller extends BasisController
{
    public function __construct()
    {
    }

    /**
     * 获取当前控制器名
     *
     * @return string
     */
    public function getCurrentControllerName()
    {
        return self::getCurrentAction()['controller'];
    }

    /**
     * 获取当前方法名
     *
     * @return string
     */
    public function getCurrentMethodName()
    {
        return self::getCurrentAction()['method'];
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */
    public function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);

        return ['controller' => $class, 'method' => $method];
    }
}
