<?php

require __DIR__ . '/../../../app/bootstrap.php';

use App\Models\VisaRequest;
use function App\Helpers\{csrf_field, csrf_verify, e, flash, redirect};
use function App\Middleware\requireLogin;

requireLogin();

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$request = $id ? VisaRequest::findById($id) : null;

if (!$request) {
    flash('error', 'Visa request not found.');
    redirect('/dashboard/visa/');
}

$errors = [];
$fields = $request;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify()) {
        $errors[] = 'Your session expired. Please try again.';
    } else {
        $fields = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'date_of_birth' => trim($_POST['date_of_birth'] ?? ''),
            'home_address' => trim($_POST['home_address'] ?? ''),
            'return_confirmation' => isset($_POST['return_confirmation']) ? 1 : 0,
            'church_name' => trim($_POST['church_name'] ?? ''),
            'church_address' => trim($_POST['church_address'] ?? ''),
            'pastor_name' => trim($_POST['pastor_name'] ?? ''),
            'pastor_email' => trim($_POST['pastor_email'] ?? ''),
            'passport_number' => trim($_POST['passport_number'] ?? ''),
            'passport_issue_date' => trim($_POST['passport_issue_date'] ?? ''),
            'passport_expiry_date' => trim($_POST['passport_expiry_date'] ?? ''),
            'consulate_country' => trim($_POST['consulate_country'] ?? ''),
            'passport_country' => trim($_POST['passport_country'] ?? ''),
        ];

        $requiredTextFields = [
            'full_name', 'email', 'home_address', 'church_name', 'church_address',
            'pastor_name', 'pastor_email', 'passport_number', 'consulate_country', 'passport_country',
        ];

        foreach ($requiredTextFields as $field) {
            if ($fields[$field] === '') {
                $errors[] = 'All fields are required.';
                break;
            }
        }

        if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }

        if (!filter_var($fields['pastor_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid pastor email address.';
        }

        foreach (['date_of_birth', 'passport_issue_date', 'passport_expiry_date'] as $dateField) {
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fields[$dateField])) {
                $errors[] = 'Please provide valid dates.';
                break;
            }
        }

        if (empty($errors)) {
            VisaRequest::update($id, $fields);
            flash('success', 'Visa request updated successfully.');
            redirect('/dashboard/visa/');
        }
    }
}

$pageTitle = 'Edit Visa Request';
$breadcrumbs = [
    ['label' => 'Dashboard', 'href' => '/dashboard/'],
    ['label' => 'Visa Letters', 'href' => '/dashboard/visa/'],
    ['label' => 'Edit'],
];

require __DIR__ . '/../../../app/components/layout_start.php';

$title = 'Edit Visa Request #' . $id;
require __DIR__ . '/../../../app/components/page_header.php';
?>
<div class="card card-border bg-base-100 shadow-sm max-w-3xl">
    <div class="card-body">
        <?php foreach ($errors as $error): ?>
            <div role="alert" class="alert alert-error mb-2"><span><?= e($error) ?></span></div>
        <?php endforeach; ?>
        <form method="post" novalidate class="flex flex-col gap-3">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $id ?>">

            <h4 class="font-semibold text-sm uppercase text-base-content/60 mt-2">Personal Information</h4>
            <label class="form-control w-full">
                <span class="label-text">Full Name</span>
                <input type="text" name="full_name" value="<?= e($fields['full_name']) ?>" class="input input-bordered w-full" required>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="form-control w-full">
                    <span class="label-text">Email Address</span>
                    <input type="email" name="email" value="<?= e($fields['email']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Date of Birth</span>
                    <input type="date" name="date_of_birth" value="<?= e($fields['date_of_birth']) ?>" class="input input-bordered w-full" required>
                </label>
            </div>
            <label class="form-control w-full">
                <span class="label-text">Full Home Address</span>
                <textarea name="home_address" class="textarea textarea-bordered w-full" rows="2" required><?= e($fields['home_address']) ?></textarea>
            </label>
            <label class="label cursor-pointer justify-start gap-3">
                <input type="checkbox" name="return_confirmation" class="checkbox" <?= $fields['return_confirmation'] ? 'checked' : '' ?>>
                <span class="label-text">I confirm I will return to my country of residence immediately after the convention.</span>
            </label>

            <h4 class="font-semibold text-sm uppercase text-base-content/60 mt-4">Church Information</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="form-control w-full">
                    <span class="label-text">Church Name</span>
                    <input type="text" name="church_name" value="<?= e($fields['church_name']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Pastor Name</span>
                    <input type="text" name="pastor_name" value="<?= e($fields['pastor_name']) ?>" class="input input-bordered w-full" required>
                </label>
            </div>
            <label class="form-control w-full">
                <span class="label-text">Church Address</span>
                <textarea name="church_address" class="textarea textarea-bordered w-full" rows="2" required><?= e($fields['church_address']) ?></textarea>
            </label>
            <label class="form-control w-full">
                <span class="label-text">Pastor Email Address</span>
                <input type="email" name="pastor_email" value="<?= e($fields['pastor_email']) ?>" class="input input-bordered w-full" required>
            </label>

            <h4 class="font-semibold text-sm uppercase text-base-content/60 mt-4">Passport / Consulate Information</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="form-control w-full">
                    <span class="label-text">Passport Number</span>
                    <input type="text" name="passport_number" value="<?= e($fields['passport_number']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Passport Country</span>
                    <input type="text" name="passport_country" value="<?= e($fields['passport_country']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Passport Issue Date</span>
                    <input type="date" name="passport_issue_date" value="<?= e($fields['passport_issue_date']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Passport Expiry Date</span>
                    <input type="date" name="passport_expiry_date" value="<?= e($fields['passport_expiry_date']) ?>" class="input input-bordered w-full" required>
                </label>
                <label class="form-control w-full">
                    <span class="label-text">Nearest British Embassy / Consulate (Country)</span>
                    <input type="text" name="consulate_country" value="<?= e($fields['consulate_country']) ?>" class="input input-bordered w-full" required>
                </label>
            </div>

            <div class="flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/dashboard/visa/" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../../../app/components/layout_end.php'; ?>
