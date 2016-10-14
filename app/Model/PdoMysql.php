<?php
class PdoMysql
{
    // 静态成员变量，用来保存类的唯一实例
    private static $_instance;
    private $_pdo;
    private $_test;

    // 用private修饰构造函数，防止外部程序来使用new关键字实例化这个类
    private function __construct()
    {
    }

    public function __call($name,$arguments){
        return call_user_func_array([$this->_pdo,$name],$arguments);
    }

    /**
     * 初始化
     */
    private function init(){
        $this->_test = 15;
        $this->_pdo = new PDO("mysql:host=".env('DB_HOST','127.0.0.1').";dbname=" . env('DB_DATABASE') . ';charset=utf8',"root",env('DB_PASSWORD'));
    }

// 覆盖php魔术方法__clone()，防止克隆
    private function __clone()
    {
        trigger_error('Clone is not allow', E_USER_ERROR);
    }

    // 单例方法，返回类唯一实例的一个引用
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
            self::$_instance->init();
        }
        return self::$_instance;
    }
}