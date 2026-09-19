<?php

namespace App\Auth;

final class Roles
{
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';

    public static function all(): array
    {
        return [self::SUPER_ADMIN, self::ADMIN];
    }

    public static function label(string $role): string
    {
        return match ($role) {
            self::SUPER_ADMIN => 'Super Admin',
            self::ADMIN => 'Admin',
            default => ucfirst($role),
        };
    }
}
