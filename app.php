<?php
/**
 * this is php construct is only for tianmingmng
 * you can visit www.tianmingming.com for more information
 * date: 2016-07-14
 */
define('app_path','./app');
define('index_path',getcwd());
define('storage_path', index_path . '/storage');
define('resource_path',index_path . '/resource');
require index_path.'/bootstrap/bootstrap.php';
$app = new App();
$app->start();
