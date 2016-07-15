<?php
/**
 * 简单的路由类，单列模式
 * Class SampleRoute
 */
class SampleRoute{
    //保存例实例在此属性中
    private static $_instance;
    //构造函数声明为private,防止直接创建对象
    private function __construct()
    {
    }
    //单例方法
    public static function singleton()
    {
        if(!isset(self::$_instance))
        {
            $c=__CLASS__;
            self::$_instance=new SampleRoute();
            self::$_instance->init();
        }
        return self::$_instance;
    }
    /**
     * 初始化函数
     */
    public function init(){
    }

    /**
     * get路由
     * @param $route
     * @param callable $fun
     */
    public function get($route,Closure $fun){

    }

    //阻止用户复制对象实例
    public function __clone()
    {
        trigger_error('Clone is not allow' ,E_USER_ERROR);
    }

    public function exec(){
        echo 'route';
    }
}