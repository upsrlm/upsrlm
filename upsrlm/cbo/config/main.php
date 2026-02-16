<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'cbo-app-frontend',
    'name' => 'UP SRLM',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'cbo\components\App'],
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
    'controllerNamespace' => 'cbo\controllers',
    'modules' => [
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
        ],
        'shg' => [
            'class' => 'cbo\modules\shg\Module',
        ],
        'vo' => [
            'class' => 'cbo\modules\vo\Module',
        ],
        'clf' => [
            'class' => 'cbo\modules\clf\Module',
        ],
        'bc' => [
            'class' => 'cbo\modules\bc\Module',
        ],
        'wada' => [
            'class' => 'cbo\modules\wada\Module',
        ],
    ],
    'components' => [
        'view' => [
//            'theme' => [
//                'basePath' => '@cbo/themes/field',
//                'baseUrl' => '@cbo/themes/field',
//                'pathMap' => ['@app/views' => '@cbo/themes/field/views'],
//            ],
            'theme' => [
                'basePath' => '@common/themes/smartadmin',
                'baseUrl' => '@common/themes/smartadmin',
                'pathMap' => ['@app/views' => '@common/themes/smartadmin/views'],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '/cbo',
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
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//                '/'=>'dashboard',
//                'changepassword' => 'site/changepassword',
//            ],
//        ],
    ],
    'params' => $params,
];
