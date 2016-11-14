<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$config = require_once("common/Conf/config.php");
// var_dump($_SERVER);
$allow_domain = "http://s.codepen.io";
// var_dump(isset($_SERVER['HTTP_ORIGIN']));
if (isset($_SERVER['HTTP_ORIGIN'])){
    $aURL = parse_url($_SERVER['HTTP_ORIGIN']);
    $is_found = false;
    foreach($config['ALLOW_ORIGIN_LIST'] as $key => $val) {
        $arr_compare = explode($_SERVER['HTTP_ORIGIN'], $val);
        $pos_str = strpos($_SERVER['HTTP_ORIGIN'], $val);
        $pos_diff = count($_SERVER['HTTP_ORIGIN']) - count($val);
        if ($pos_str == $pos_diff) {
            $is_found = true;
            break;
        }
    }
    if ($is_found){
        $allow_domain = $_SERVER['HTTP_ORIGIN'];
    }
    header('Access-Control-Allow-Origin: ' . $allow_domain); 
} 

require_once("constant.inc.php");
// require_once("/var/www/vendor/tencentyun/php-sdk");

require_once("/var/www/vendor/autoload.php");
require_once("common/Conf/config.tencentyun.php");
require_once("/var/www/vendor/topthink/thinkphp/ThinkPHP/ThinkPHP.php");