<?php
session_cache_expire('0');
session_start();
use controller\MainController;
$config = require __DIR__.'/config/config.php';

try{
    $dbc = new PDO($config['dbConf']['dsn'], $config['dbConf']['user'], $config['dbConf']['password']);
}
catch(PDOException $e){
    echo 'Не удалось подключиться к базе данных. ' . $e->getMessage();
}

spl_autoload_register(function($class){
    include  $class . '.php';
});

//var_dump(password_hash('H7m823ko9cM', PASSWORD_BCRYPT));
/*echo '<pre>';
var_dump(preg_replace('/семен/', "456", 'Семенов'));
echo '</pre>';*/
$app = new MainController($dbc, $config);
$app->pageDefine();