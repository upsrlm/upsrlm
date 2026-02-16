<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Calcutta',
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                'bedezign\yii2\audit\migrations',
            ],
        ],
    ],
//    'modules' => [
//        'transaction' => [
//            'class' => 'bc\modules\transaction\Module',
//        ],
//    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
        ],
        //        'log' => [
        //            'targets' => [
        //                [
        //                    'class' => 'yii\log\FileTarget',
        //                    'levels' => ['error', 'warning'],
        //                ],
        //            ],
        //        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Calcutta',
        ]
    ],
    'params' => $params,
];
