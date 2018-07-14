<?php
session_cache_expire('0');
session_start();
define('ROOT_DIR', __DIR__);
use controller\MainController;
$config = require __DIR__.'/config/config.php';
require(__DIR__.'/plugins/smarty/libs/SmartyUser.php');
$smarty = new SmartyUser();
try{
    $dbc = new PDO($config['dbConf']['dsn'], $config['dbConf']['user'], $config['dbConf']['password']);
}
catch(PDOException $e){
    echo 'Не удалось подключиться к базе данных. ' . $e->getMessage();
}

spl_autoload_register(function($class){
    include  $class . '.php';
});

$app = new MainController($dbc, $config, $smarty);
$app->pageDefine();