<?php
/**
 * User: 120.79.139.251:cuioo.cuiwq.cn
 * Date: 2018/1/24
 * Time: 21:05
 */

/**
 * 工厂模式实现单例,批量生产对象
 * Class ObjFactory
 */
class ObjFactory
{
    //私有静态成员属性 用于保存创建的对象
    private static $objs = [];
    //私有构造,这个不需要new
    private function __construct()
    {
    }
    //私有克隆,更严谨,通过对象工厂只能调用方法创建类对象,
    private function __clone()
    {
    }
    /**
     * 只能批量不需要初始化,或者构造传参的对象
     * @param $class_name 类名-创建出此类对象
     * @return mixed
     */
    public static function createObj($class_name){
        if(!isset($objs[$class_name])){
            self::$objs[$class_name] = new $class_name();
        }
        return self::$objs[$class_name];
    }
}