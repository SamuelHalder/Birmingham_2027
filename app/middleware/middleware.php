<?php

namespace App\Middleware;

use App\Auth\Auth;

function requireLogin(): void
{
    if (!Auth::check()) {
        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? '/dashboard/';
        header('Location: /login.php');
        exit;
    }
}

function requireRole(string ...$roles): void
{
    requireLogin();

    if (!in_array(Auth::role(), $roles, true)) {
        http_response_code(403);
        require dirname(__DIR__) . '/components/forbidden.php';
        exit;
    }
}
