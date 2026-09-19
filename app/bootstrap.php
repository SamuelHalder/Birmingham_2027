<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// Simple PSR-4-ish autoloader for the App\ namespace (no Composer dependency).
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';

    if (is_file($path)) {
        require $path;
    }
});

require_once __DIR__ . '/helpers/helpers.php';
require_once __DIR__ . '/middleware/middleware.php';

use App\Auth\Auth;

Auth::start();

date_default_timezone_set('Europe/London');

$appConfig = require __DIR__ . '/config/config.php';

if ($appConfig['app']['debug']) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL);
}
