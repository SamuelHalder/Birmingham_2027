<?php
// Minimal .env loader (no external dependency).

function load_env(string $path): void
{
    static $loaded = false;
    if ($loaded || !is_file($path)) {
        return;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        [$name, $value] = array_pad(explode('=', $line, 2), 2, '');
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if ($name === '') {
            continue;
        }

        putenv("{$name}={$value}");
        $_ENV[$name] = $value;
    }

    $loaded = true;
}

function env(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? getenv($key);
    if ($value === false || $value === null) {
        return $default;
    }

    return match (strtolower($value)) {
        'true' => true,
        'false' => false,
        'null' => null,
        default => $value,
    };
}
