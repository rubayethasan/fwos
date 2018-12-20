<?php

if($_SERVER['HTTP_HOST'] == 'local.fwos.de'){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=Planspiel_MySQL',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ];
}else{
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=mysqldb.gwdg.de:3307;dbname=planspiel_fwos',
        'username' => 'fwos_user',
        'password' => '0osjV8Piy',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ];
}



