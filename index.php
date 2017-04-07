<?php
date_default_timezone_set("Europe/Amsterdam");
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
// include Yii bootstrap file


// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii-framework-1.1.17/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
include 'function.php';

require_once($yii);
Yii::createWebApplication($config)->run();