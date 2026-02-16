<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'UP SRLM',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'backend\components\App'],
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
    'layout' => 'main_admin',
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
        'master' => [
            'class' => 'app\modules\master\Module',
        ],
        'front' => [
            'class' => 'backend\modules\front\Module',
        ],
        'bc' => [
            'class' => 'backend\modules\bc\Module',
        ],
        'cbo' => [
            'class' => 'backend\modules\cbo\Module',
        ],
        'analytics' => [
            'class' => 'backend\modules\analytics\Module',
        ],
        'rishta' => [
            'class' => 'backend\modules\rishta\Module',
        ],
        'cloudtel' => [
            'class' => 'backend\modules\cloudtel\Module',
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
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
                'path' => '/',
                'domain' => '.upsrlm.local',
            ],
        ],
        'session' => [
            // Separate backend session to avoid clashing with frontend.
            'name' => 'UPSRLMSESSID_BACKEND',
            'cookieParams' => [
                'httpOnly' => true,
                'path' => '/',
                'domain' => '.upsrlm.local',
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
                '/' => 'dashboard',
                'changepassword' => 'site/changepassword',
            ],
        ],
    ],
    'params' => $params,
];
