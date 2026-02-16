<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'BC Call Center',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'bccallcenter\components\App'],
    'controllerNamespace' => 'bccallcenter\controllers',
    'layout' => 'main_bccallcenter',
    'modules' => [
        'dashboard' => [
            'class' => 'bccallcenter\modules\dashboard\Module',
        ],
        'platform' => [
            'class' => 'bccallcenter\modules\platform\Module',
        ],
        'monitoring' => [
            'class' => 'bccallcenter\modules\monitoring\Module',
        ],
        'bc' => [
            'class' => 'bccallcenter\modules\bc\Module',
        ],
         'shg' => [
            'class' => 'bccallcenter\modules\shg\Module',
        ],
        'clf' => [
            'class' => 'bccallcenter\modules\clf\Module',
        ],
        'vo' => [
            'class' => 'bccallcenter\modules\vo\Module',
        ],
        'rishta' => [
            'class' => 'bccallcenter\modules\rishta\Module',
        ],
         'report' => [
            'class' => 'bccallcenter\modules\report\Module',
        ],
        'rsetis' => [
            'class' => 'bccallcenter\modules\rsetis\Module',
        ],
        'tracking' => [
            'class' => 'bccallcenter\modules\tracking\Module',
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
            'baseUrl' => '/bccallcenter',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
                '/' => 'dashboard/default/index',
                'changepassword' => 'site/changepassword',
            ],
        ],
    ],
    'params' => $params,
];
