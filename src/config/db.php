<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 3600,
];