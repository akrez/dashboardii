<?php

$config = require __DIR__ . '/constants.php';
$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'dashboardii-console',
    'name' => APP_NAME,
    'basePath' => BASE_PATH,
    'language' => 'fa-IR',
    'bootstrap' => ['log'],
    'vendorPath' => VENDOR_PATH,
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $params['db'],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            'cache' => 'cache',
        ],
    ],
    'params' => $params['params'],
    'controllerMap' => [
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
