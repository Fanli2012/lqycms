<?php
// +----------------------------------------------------------------------
// | PHP设计模式-单例模式
// | 单例模式解决的是如何在整个项目中创建唯一对象实例的问题
// +----------------------------------------------------------------------
namespace app\common\lib;

class Factory
{
    private static $Factory;

    private function __construct()
    {
        
    }

    public static function getInstance($className, $options = null)
    {
        if(!isset(self::$Factory[$className]) || !self::$Factory[$className])
        {
            self::$Factory[$className] = new $className($options);
        }
        
        return self::$Factory[$className];
    }
}

/**
 * 示例
 * Factory::getInstance(\app\api\controller\Oauth::class);
 */