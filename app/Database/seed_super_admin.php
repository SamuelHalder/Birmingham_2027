<?php

// Run via CLI: php app/database/seed_super_admin.php "Name" "email@example.com" "Password123!"

require __DIR__ . '/../config/env.php';
require __DIR__ . '/Database.php';

use App\Database\Database;

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('This script can only be run from the command line.');
}

[$name, $email, $password] = [$argv[1] ?? null, $argv[2] ?? null, $argv[3] ?? null];

if (!$name || !$email || !$password) {
    fwrite(STDERR, "Usage: php seed_super_admin.php \"Name\" \"email@example.com\" \"Password123!\"\n");
    exit(1);
}

if (strlen($password) < 8) {
    fwrite(STDERR, "Password must be at least 8 characters.\n");
    exit(1);
}

$stmt = Database::connection()->prepare(
    'INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :password_hash, :role)
     ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash), role = VALUES(role), is_active = 1'
);

$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    'role' => 'super_admin',
]);

echo "Super admin '{$email}' created/updated successfully.\n";
