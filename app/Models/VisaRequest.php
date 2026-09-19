<?php

namespace App\Models;

use App\Database\Database;

final class VisaRequest
{
    private const FIELDS = [
        'full_name', 'email', 'date_of_birth', 'home_address', 'return_confirmation',
        'church_name', 'church_address', 'pastor_name', 'pastor_email',
        'passport_number', 'passport_issue_date', 'passport_expiry_date',
        'consulate_country', 'passport_country',
    ];

    public static function all(): array
    {
        return Database::connection()
            ->query('SELECT * FROM visa_requests ORDER BY created_at DESC')
            ->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::connection()->prepare('SELECT * FROM visa_requests WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $request = $stmt->fetch();

        return $request ?: null;
    }

    public static function update(int $id, array $data): void
    {
        $assignments = implode(', ', array_map(static fn ($field) => "{$field} = :{$field}", self::FIELDS));

        $stmt = Database::connection()->prepare("UPDATE visa_requests SET {$assignments} WHERE id = :id");

        $params = ['id' => $id];
        foreach (self::FIELDS as $field) {
            $params[$field] = $data[$field] ?? null;
        }

        $stmt->execute($params);
    }
}
