<?php

require __DIR__ . '/../../../app/bootstrap.php';

use App\Auth\Roles;
use App\Auth\User;
use function App\Helpers\e;
use function App\Middleware\requireRole;

requireRole(Roles::SUPER_ADMIN);

$pageTitle = 'Users';
$breadcrumbs = [['label' => 'Dashboard', 'href' => '/dashboard/'], ['label' => 'Users']];
$users = User::all();

require __DIR__ . '/../../../app/components/layout_start.php';

$title = 'Users';
$subtitle = 'Manage administration panel accounts';
$actionsHtml = '<a href="/dashboard/users/create.php" class="btn btn-primary">Add User</a>';
require __DIR__ . '/../../../app/components/page_header.php';
?>
<div class="card card-border bg-base-100 shadow-sm">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= e($user['name']) ?></td>
                            <td><?= e($user['email']) ?></td>
                            <td><?= e(Roles::label($user['role'])) ?></td>
                            <td>
                                <?php if ($user['is_active']): ?>
                                    <span class="badge badge-success badge-soft">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-error badge-soft">Disabled</span>
                                <?php endif; ?>
                            </td>
                            <td><?= e($user['last_login_at'] ?? 'Never') ?></td>
                            <td class="text-right">
                                <a href="/dashboard/users/edit.php?id=<?= (int) $user['id'] ?>" class="btn btn-sm btn-ghost">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center text-base-content/60">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../../app/components/layout_end.php'; ?>
