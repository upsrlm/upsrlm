<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'bcsakhi-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'bcsakhi\controllers',
    'layout' => 'main',
    'homeUrl' => ['/page/home'],
    'modules' => [
        'page' => [
            'class' => 'bcsakhi\modules\page\Module',
        ],
        'viewdashboard' => [
            'class' => 'bcsakhi\modules\viewdashboard\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@common/themes/bcsakhinew',
                'baseUrl' => '@web/themes/bcsakhinew',
                'pathMap' => ['@app/views' => '@common/themes/bcsakhinew/views'],
            ],
        ],
//        'assetManager' => [
//            'linkAssets' => true,
//            'appendTimestamp' => true,
//        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'page/home',
            ],
        ],
    ],
    'params' => $params,
];
