<?php
/**
 * Environment configuration helper
 * Loads .env file if exists, provides clean configuration interface
 * 
 * Usage in main config:
 *   $env = require __DIR__ . '/env.php';
 *   'cookieValidationKey' => $env['COOKIE_VALIDATION_KEY'],
 */

use Dotenv\Dotenv;

// Import Exception for error handling
use Exception;

$basePath = dirname(dirname(__DIR__));

// Load .env file if it exists
if (file_exists($basePath . '/.env')) {
    $dotenv = Dotenv::createImmutable($basePath);
    $dotenv->load();
}

// Helper: get required env var
if (!function_exists('getEnvStrict')) {
    function getEnvStrict($key, $default = null) {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        if ($value === null) {
            throw new Exception("Required environment variable not set: $key");
        }
        if ($value === 'true') return true;
        if ($value === 'false') return false;
        if (is_numeric($value)) return (int)$value;
        return $value;
    }
}

// Helper: get optional env var
if (!function_exists('getEnvSafe')) {
    function getEnvSafe($key, $default = null) {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        if ($value === null) {
            return $default;
        }
        if ($value === 'true') return true;
        if ($value === 'false') return false;
        if (is_numeric($value)) return (int)$value;
        return $value;
    }
}

return [
    // Database
    'DB_HOST' => getEnvSafe('DB_HOST', 'localhost'),
    'DB_PORT' => getEnvSafe('DB_PORT', 3306),
    'DB_NAME' => getEnvSafe('DB_NAME', 'yii2advanced'),
    'DB_USER' => getEnvSafe('DB_USER', 'root'),
    'DB_PASSWORD' => getEnvSafe('DB_PASSWORD', ''),
    'DB_CHARSET' => getEnvSafe('DB_CHARSET', 'utf8mb4'),

    // Security
    'COOKIE_VALIDATION_KEY' => getEnvStrict('COOKIE_VALIDATION_KEY'),
    'JWT_SECRET' => getEnvStrict('JWT_SECRET'),
    'JWT_ALGORITHM' => getEnvSafe('JWT_ALGORITHM', 'HS256'),
    'JWT_EXPIRY' => getEnvSafe('JWT_EXPIRY', 3600),

    // Email
    'MAIL_HOST' => getEnvSafe('MAIL_HOST', 'localhost'),
    'MAIL_PORT' => getEnvSafe('MAIL_PORT', 587),
    'MAIL_USERNAME' => getEnvSafe('MAIL_USERNAME', 'user@example.com'),
    'MAIL_PASSWORD' => getEnvSafe('MAIL_PASSWORD', ''),
    'MAIL_ENCRYPTION' => getEnvSafe('MAIL_ENCRYPTION', 'tls'),
    'MAIL_FROM_EMAIL' => getEnvSafe('MAIL_FROM_EMAIL', 'noreply@example.com'),
    'MAIL_FROM_NAME' => getEnvSafe('MAIL_FROM_NAME', 'UPSRLM'),

    // Application
    'YII_DEBUG' => getEnvSafe('YII_DEBUG', false),
    'YII_ENV' => getEnvSafe('YII_ENV', 'prod'),

    // SMS (Optional)
    'SMS_LANE_ENABLE' => getEnvSafe('SMS_LANE_ENABLE', false),
    'SMS_LANE_API_KEY' => getEnvSafe('SMS_LANE_API_KEY', ''),

    // API
    'API_LOG_LEVEL' => getEnvSafe('API_LOG_LEVEL', 'error'),
    'API_RESPONSE_FORMAT' => getEnvSafe('API_RESPONSE_FORMAT', 'json'),
];
