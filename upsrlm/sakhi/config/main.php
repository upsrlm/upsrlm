<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-sakhi',
    'name' => 'UP SRLM Sakhi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'sakhi\components\App'],
    'controllerNamespace' => 'sakhi\controllers',
    'layout' => 'mobile_view',
    'modules' => [
        'bc' => [
            'class' => 'sakhi\modules\bc\Module',
        ],
        'shg' => [
            'class' => 'sakhi\modules\shg\Module',
        ],
        'vo' => [
            'class' => 'sakhi\modules\vo\Module',
        ],
        'clf' => [
            'class' => 'sakhi\modules\clf\Module',
        ],
        'api' => [
            'class' => 'sakhi\modules\api\Module',
        ],
        'page' => [
            'class' => 'sakhi\modules\page\Module',
        ],
         'user' => [
            'class' => 'sakhi\modules\user\Module',
        ],
        'test' => [
            'class' => 'sakhi\modules\test\Module',
        ],
        'online' => [
            'class' => 'sakhi\modules\online\Module',
        ],
        'hhs' => [
            'class' => 'sakhi\modules\hhs\Module',
        ],
    ],
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => '@common/themes/smartadmin',
                'baseUrl' => '@common/themes/smartadmin',
                'pathMap' => ['@app/views' => '@common/themes/smartadmin/views'],
            ],
//             'theme' => [
//                'basePath' => '@sakhi/themes/field',
//                'baseUrl' => '@sakhi/themes/field',
//                'pathMap' => ['@app/views' => '@sakhi/themes/fiori/views'],
//            ],
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
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => 'secret',
            // You have to configure ValidationData informing all claims you want to validate the token.
            'jwtValidationData' => \sakhi\components\JwtValidationData::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'rest/index',
            ],
        ],
    ],
    'params' => $params,
];
