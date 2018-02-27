<?php
return array(
    'db' =>
        [
//        'host'=>'127.0.0.1',
//        'username'=>'root',
            'password'=>'root',
            'database'=>'blog',
//        'port'=>3306,
//        'cahrset'=>'utf8',
        ],
    'pdo' =>
        [
            //$psn,$user,$pwd
            'psn' => 'mysql:host=127.0.0.1;dbname=blog;charset=utf8;port=3306',
            'username' => 'root',
            'password' => 'root',
            'errmode' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]
        ],
    'app' => array(
        'default_platform' => 'Home',
        'default_controller' => 'Home',
        'default_action' => 'index'
    )
);