<?php

require __DIR__ . '/../app/bootstrap.php';

use App\Auth\Auth;
use function App\Helpers\{csrf_field, csrf_verify, e, flash, redirect};

if (Auth::check()) {
    redirect('/dashboard/');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = (string) ($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $errors[] = 'Email and password are required.';
        } elseif (Auth::attempt($email, $password)) {
            $redirectTo = $_SESSION['intended_url'] ?? '/dashboard/';
            unset($_SESSION['intended_url']);
            redirect($redirectTo);
        } else {
            $errors[] = 'Invalid credentials or inactive account.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &middot; Birmingham 2027</title>
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-base-200 p-4">
    <div class="card w-full max-w-sm card-border bg-base-100 shadow-sm">
        <div class="card-body">
            <h1 class="card-title">Birmingham 2027</h1>
            <p class="text-sm text-base-content/60 mb-2">Convention Admin Panel</p>

            <?php foreach ($errors as $error): ?>
                <div role="alert" class="alert alert-error mb-2">
                    <span><?= e($error) ?></span>
                </div>
            <?php endforeach; ?>

            <form method="post" novalidate class="flex flex-col gap-3">
                <?= csrf_field() ?>
                <label class="form-control w-full">
                    <span class="label-text">Email</span>
                    <input type="email" name="email" class="input input-bordered w-full" required autofocus>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Password</span>
                    <input type="password" name="password" class="input input-bordered w-full" required>
                </label>
                <button type="submit" class="btn btn-primary mt-2">Log in</button>
            </form>
        </div>
    </div>
</body>
</html>
