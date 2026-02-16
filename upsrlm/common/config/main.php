<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone'   => 'Asia/Kolkata',

    'modules' => [
        // Third-party modules
        'social' => [
            'class' => 'kartik\social\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',
        ],

        // Business modules
        'bc' => ['class' => 'bc\Module'],
		'cbo' => ['class' => 'cbo\Module'],
		'report' => ['class' => 'bc\modules\report\Module'],
		'transaction' => ['class' => 'bc\modules\transaction\Module'],

    ],

    'components' => [
	'appcheck' => [
        'class' => 'common\components\AppCheck',
    ],
        'session' => [
            'name' => 'UPSRLMSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
                'domain'   => '.upsrlm.local', // shared across subdomains
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-upsrlm',
            'cookieValidationKey' => 'REPLACE_WITH_RANDOM_SECRET', // generate securely
            'enableCsrfValidation' => true,
        ],
        'user' => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-upsrlm',
                'httpOnly' => true,
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailerupsrlm' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class'    => 'Swift_SmtpTransport',
                'host'     => 'smtpout.secureserver.net',
                'username' => 'mail@upsrlm.org',
                'password' => '', // fill securely or via env vars
                'port'     => '465',
                'encryption' => 'ssl',
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                    ],
                ],
            ],
        ],
        'AirPhone' => [
            'class' => \common\components\AirPhone::class,
        ],
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key'   => 'secret', // replace with strong random key
            'jwtValidationData' => \common\components\JwtValidationData::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => [
                '/' => 'dashboard',

                // BC module
               'bc' => 'bc/dashboard/index',   // map /bc → DashboardController::actionIndex()
				'bc/<controller>/<action>' => 'bc/<controller>/<action>',

                // CBO module
                'cbo' => 'cbo/shg/default/index',
				'cbo/<controller>/<action>' => 'cbo/<controller>/<action>',
				'cbo/<module>/<controller>/<action>' => 'cbo/<module>/<controller>/<action>', 

                // HR module
                'hr' => 'hr/default/index',
                'hr/<controller>/<action>' => 'hr/<controller>/<action>',

                // Report module (nested under BC)
                'report' => 'report/default/index',
                'report/<controller>/<action>' => 'report/<controller>/<action>',

                // Transaction module (nested under BC)
                'transaction' => 'transaction/default/index',
                'transaction/<controller>/<action>' => 'transaction/<controller>/<action>',
            ],
        ],
    ],
];