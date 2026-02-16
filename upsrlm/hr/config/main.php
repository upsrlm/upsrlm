<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'UP SRLM',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'hr\components\App'],
    'on beforeRequest' => function ($event) {
        if (Yii::$app->params['portalMode'] == 'maintenance') {
            $letMeIn = Yii::$app->session['letMeIn'];
            if (!$letMeIn) {
                Yii::$app->catchAll = [
                    // force route if portal in maintenance mode
                    'site/maintenance',
                ];
            }else{
                Yii::$app->session['letMeIn'] = 1;
            }
        }
    },
    'controllerNamespace' => 'hr\controllers',
    'layout' => 'main_hr',
    'modules' => [
        'social' => [
            'class' => 'kartik\social\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => '@common/themes/smartadmin',
                'baseUrl' => '@common/themes/smartadmin',
                'pathMap' => ['@app/views' => '@common/themes/smartadmin/views'],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '/hr',
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the frontend
//            'name' => 'advanced-frontend',
//        ],
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'dashboard',
                'changepassword' => 'site/changepassword',
                'getimage/<path:.*>' => 'site/getimage',
            ],
        ],
    ],
    'params' => $params,
];
