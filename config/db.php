<?php

/*return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];*/

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
