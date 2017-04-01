<?php
/**
 * this is php construct is only for tianmingmng
 * you can visit www.tianmingming.com for more information
 * date: 2016-07-14
 */
error_reporting(E_ERROR);
ini_set('date.timezone','Asia/Shanghai');
ini_set('display_errors', '1');
define('app_path','./app');
define('index_path',__DIR__);
define('storage_path', index_path . '/storage');
define('resource_path',index_path . '/resource');
define('preview_path',index_path . '/storage/preview');
include(__DIR__ . '/vendor/autoload.php');
require __DIR__.'/bootstrap/bootstrap.php';
$app = new App();
$app->start();
