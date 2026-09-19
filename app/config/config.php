<?php

require_once __DIR__ . '/env.php';

load_env(dirname(__DIR__, 2) . '/.env');

return [
    'app' => [
        'env' => env('APP_ENV', 'production'),
        'debug' => env('APP_DEBUG', false),
        'url' => env('APP_URL', 'http://localhost'),
    ],
    'database' => [
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', ''),
        'username' => env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
    ],
    'session' => [
        'name' => env('SESSION_NAME', 'b27_session'),
    ],
];
