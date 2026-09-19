<?php

require __DIR__ . '/../../../app/bootstrap.php';

use App\Auth\Roles;
use App\Auth\User;
use function App\Helpers\{csrf_field, csrf_verify, e, flash, redirect};
use function App\Middleware\requireRole;

requireRole(Roles::SUPER_ADMIN);

$errors = [];
$name = '';
$email = '';
$role = Roles::ADMIN;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');
        $role = $_POST['role'] ?? Roles::ADMIN;

        if ($name === '' || $email === '' || $password === '') {
            $errors[] = 'Name, email, and password are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        } elseif (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        } elseif (!in_array($role, Roles::all(), true)) {
            $errors[] = 'Invalid role selected.';
        } elseif (User::emailExists($email)) {
            $errors[] = 'A user with this email already exists.';
        } else {
            User::create($name, $email, $password, $role);
            flash('success', 'User created successfully.');
            redirect('/dashboard/users/');
        }
    }
}

$pageTitle = 'Add User';
$breadcrumbs = [
    ['label' => 'Dashboard', 'href' => '/dashboard/'],
    ['label' => 'Users', 'href' => '/dashboard/users/'],
    ['label' => 'Add User'],
];

require __DIR__ . '/../../../app/components/layout_start.php';

$title = 'Add User';
require __DIR__ . '/../../../app/components/page_header.php';
?>
<div class="card card-border bg-base-100 shadow-sm max-w-lg">
    <div class="card-body">
        <?php foreach ($errors as $error): ?>
            <div role="alert" class="alert alert-error mb-2"><span><?= e($error) ?></span></div>
        <?php endforeach; ?>
        <form method="post" novalidate class="flex flex-col gap-3">
            <?= csrf_field() ?>
            <label class="form-control w-full">
                <span class="label-text">Name</span>
                <input type="text" name="name" value="<?= e($name) ?>" class="input input-bordered w-full" required>
            </label>
            <label class="form-control w-full">
                <span class="label-text">Email</span>
                <input type="email" name="email" value="<?= e($email) ?>" class="input input-bordered w-full" required>
            </label>
            <label class="form-control w-full">
                <span class="label-text">Password</span>
                <input type="password" name="password" class="input input-bordered w-full" required minlength="8">
            </label>
            <label class="form-control w-full">
                <span class="label-text">Role</span>
                <select name="role" class="select select-bordered w-full">
                    <?php foreach (Roles::all() as $roleOption): ?>
                        <option value="<?= e($roleOption) ?>" <?= $role === $roleOption ? 'selected' : '' ?>>
                            <?= e(Roles::label($roleOption)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="/dashboard/users/" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../../app/components/layout_end.php'; ?>
