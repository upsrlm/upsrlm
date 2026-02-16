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
    'bootstrap' => ['log'],
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
    'homeUrl' => ['/page/home'],
    'layout' => 'static',
    'controllerNamespace' => 'frontend\controllers',
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
        'page' => [
            'class' => 'app\modules\page\Module',
        ],
        'master' => [
            'class' => 'app\modules\master\Module',
        ],
        'viewdashboard' => [
            'class' => 'app\modules\viewdashboard\Module',
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
////            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the frontend
//            'name' => 'advanced-frontend',
//        ],
        'view' => [
            'theme' => [
                'basePath' => '@common/themes/fiori',
                'baseUrl' => '@web/themes/fiori',
                'pathMap' => ['@app/views' => '@common/themes/fiori/views'],
            ],
        ],
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
                '/' => 'page/home',
                'changepassword' => 'site/changepassword',
                'forgotpassword' => 'page/forgotpassword',
                'vaccantgp' => 'page/gp/openbcapplication',
            ],
        ],
    ],
    'params' => $params,
];
