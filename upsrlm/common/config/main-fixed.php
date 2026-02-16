<?php
/**
 * Common application configuration for ALL applications
 * This file contains shared settings for frontend, backend, api, etc.
 * 
 * SECURITY CRITICAL:
 * - All sensitive values loaded from environment variables
 * - Never commit secrets to repository
 * - See .env.example for required configuration
 */

// Load environment configuration
$env = require __DIR__ . '/env.php';

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
        
        /**
         * SESSION CONFIGURATION
         * httpOnly: Prevents JavaScript from accessing cookies (XSS protection)
         * secure: Should be true in production (HTTPS only)
         * sameSite: Prevent CSRF attacks by restricting cookie submission
         */
        'session' => [
            'name' => 'UPSRLMSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'secure' => $env['YII_ENV'] === 'prod',  // HTTPS only in production
                'sameSite' => 'Lax',
                'path'     => '/',
                'domain'   => '.upsrlm.local',
            ],
        ],
        
        /**
         * REQUEST CONFIGURATION
         * enableCsrfValidation: Enabled globally for all POST/PUT/DELETE
         * cookieValidationKey: Must be cryptographically random, 32+ bytes
         */
        'request' => [
            'csrfParam' => '_csrf-upsrlm',
            'cookieValidationKey' => $env['COOKIE_VALIDATION_KEY'],
            'enableCsrfValidation' => true,
        ],
        
        /**
         * USER AUTHENTICATION
         * identityCookie: Encrypted auth cookie for persistent login
         */
        'user' => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-upsrlm',
                'httpOnly' => true,
                'secure' => $env['YII_ENV'] === 'prod',
                'sameSite' => 'Lax',
            ],
            'idParam' => '__id',
            'authTimeoutParam' => '__expire',
        ],
        
        /**
         * CACHING CONFIGURATION
         * Consider upgrading to Redis/Memcached for production
         */
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
        /**
         * DATABASE CONFIGURATION
         * Using Yii's built-in query builders protects against SQL injection
         */
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . $env['DB_HOST'] . 
                    ';port=' . $env['DB_PORT'] . 
                    ';dbname=' . $env['DB_NAME'],
            'username' => $env['DB_USER'],
            'password' => $env['DB_PASSWORD'],
            'charset' => $env['DB_CHARSET'],
            'enableLogging' => true,
            'enableProfiling' => $env['YII_DEBUG'],
        ],
        
        /**
         * EMAIL CONFIGURATION
         * SECURITY FIX: Removed SSL verification disable
         * Uses proper TLS with certificate verification enabled
         */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $env['MAIL_HOST'],
                'username' => $env['MAIL_USERNAME'],
                'password' => $env['MAIL_PASSWORD'],
                'port' => $env['MAIL_PORT'],
                'encryption' => $env['MAIL_ENCRYPTION'],
                // Removed dangerous SSL verification disable:
                // 'streamOptions' => ['ssl' => ['verify_peer' => false, ...]]
                // Modern SMTP endpoints are properly signed and verified by default
            ],
            'from' => [
                $env['MAIL_FROM_EMAIL'] => $env['MAIL_FROM_NAME']
            ],
        ],
        
        /**
         * ALTERNATIVE MAILER for specific instances
         * Can be used if main mailer is not suitable
         */
        'mailerupsrlm' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => $env['MAIL_HOST'],
                'username' => $env['MAIL_USERNAME'],
                'password' => $env['MAIL_PASSWORD'],
                'port' => $env['MAIL_PORT'],
                'encryption' => $env['MAIL_ENCRYPTION'],
            ],
        ],
        
        /**
         * THIRD-PARTY COMPONENTS
         */
        // 'AirPhone' component registration (uncomment if used)
        // 'AirPhone' => [
        //     'class' => \common\components\AirPhone::class,
        // ],
        
        /**
         * JWT CONFIGURATION for API
         * SECURITY FIX: Use environment variable for secret
         * Algorithm: HS256 for stateless auth, RS256 for public/private key
         */
        'jwt' => [
            'class' => \sizeg\jwt\Jwt::class,
            'key' => $env['JWT_SECRET'],
            'algorithm' => $env['JWT_ALGORITHM'],
            'jwtValidationData' => \common\components\JwtValidationData::class,
        ],
        
        /**
         * URL ROUTING CONFIGURATION
         * enablePrettyUrl: SEO-friendly URLs without index.php
         * rules: Custom routing for modules
         */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules' => [
                '/' => 'dashboard',

                // BC module
                'bc' => 'bc/dashboard/index',
                'bc/<controller>/<action>' => 'bc/<controller>/<action>',

                // CBO module
                'cbo' => 'cbo/shg/default/index',
                'cbo/<controller>/<action>' => 'cbo/<controller>/<action>',
                'cbo/<module>/<controller>/<action>' => 'cbo/<module>/<controller>/<action>',

                // HR module
                'hr' => 'hr/default/index',
                'hr/<controller>/<action>' => 'hr/<controller>/<action>',

                // Report module
                'report' => 'report/default/index',
                'report/<controller>/<action>' => 'report/<controller>/<action>',

                // Transaction module
                'transaction' => 'transaction/default/index',
                'transaction/<controller>/<action>' => 'transaction/<controller>/<action>',
            ],
        ],
        
        /**
         * ERROR HANDLING
         * Custom error handler for security
         */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        /**
         * LOGGING CONFIGURATION
         */
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/app.log',
                    'maxFileSize' => 10 * 1024 * 1024,  // 10MB
                    'maxLogFiles' => 5,
                ],
            ],
        ],
    ],
    
    /**
     * APPLICATION PARAMETERS
     * Non-sensitive configuration parameters
     */
    'params' => [
        'adminEmail' => 'admin@example.com',
        'supportEmail' => 'support@example.com',
        'user.passwordMinLength' => 8,
        'user.passwordResetTokenExpire' => 3600,  // 1 hour
    ],
];
