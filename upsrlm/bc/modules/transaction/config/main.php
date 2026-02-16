<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-bc',
    'name' => 'UP SRLM',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'bc\components\App'],
    'controllerNamespace' => 'bc\controllers',
    'layout' => 'main_bc',
    'modules' => [
        'selection' => [
            'class' => 'app\modules\selection\Module',
        ],
        'training' => [
            'class' => 'bc\modules\training\Module',
        ],
        'report' => [
            'class' => 'bc\modules\report\Module',
        ],
        'corona' => [
            'class' => 'bc\modules\corona\Module',
        ],
        'partneragencies' => [
            'class' => 'bc\modules\partneragencies\Module',
        ],
        'md' => [
            'class' => 'bc\modules\md\Module',
        ],
        'transaction' => [
            'class' => 'bc\modules\transaction\Module',
        ],
    ],
    'components' => [
        'view' => [
            //             'theme' => [
            //                'basePath' => '@bc/themes/fiori',
            //                'baseUrl' => '@bc/themes/fiori',
            //                'pathMap' => ['@bc/views' => '@bc/themes/fiori/views'],
            //            ],
            //            'theme' => [
            //                'basePath' => '@bc/themes/field',
            //                'baseUrl' => '@bc/themes/field',
            //                'pathMap' => ['@bc/views' => '@bc/themes/field/views'],
            //            ],
            'theme' => [
                'basePath' => '@common/themes/smartadmin',
                'baseUrl' => '@common/themes/smartadmin',
                'pathMap' => ['@app/views' => '@common/themes/smartadmin/views'],
            ],
        ],
        //        'request' => [
        //            'csrfParam' => '_csrf-frontend',
        //        ],
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
                //'/' => 'selection/dashboard/default',
                //'' => 'selection/dashboard/default',
                //'/' => 'training/participants',
                //'' => 'training/participants',
                //                '/' => 'report/dashboard',
                //                '' => 'report/dashboard',
                'changepassword' => 'site/changepassword',
            ],
        ],
    ],
    'params' => $params,
];
