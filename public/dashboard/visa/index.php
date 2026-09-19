<?php

require __DIR__ . '/../../../app/bootstrap.php';

use App\Models\VisaRequest;
use function App\Helpers\e;
use function App\Middleware\requireLogin;

requireLogin();

$pageTitle = 'Visa Letters';
$breadcrumbs = [['label' => 'Dashboard', 'href' => '/dashboard/'], ['label' => 'Visa Letters']];
$requests = VisaRequest::all();

require __DIR__ . '/../../../app/components/layout_start.php';

$title = 'Visa Letters';
$subtitle = 'Visa invitation requests submitted for the convention';
require __DIR__ . '/../../../app/components/page_header.php';
?>
<div class="card card-border bg-base-100 shadow-sm">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Passport Number</th>
                        <th>Passport Country</th>
                        <th>Submitted</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $request): ?>
                        <tr>
                            <td><?= (int) $request['id'] ?></td>
                            <td><?= e($request['full_name']) ?></td>
                            <td><?= e($request['email']) ?></td>
                            <td><?= e($request['passport_number']) ?></td>
                            <td><?= e($request['passport_country']) ?></td>
                            <td><?= e($request['created_at']) ?></td>
                            <td class="text-right whitespace-nowrap">
                                <button type="button" class="btn btn-sm btn-ghost" onclick="view_<?= (int) $request['id'] ?>.showModal()">View More</button>
                                <a href="/dashboard/visa/edit.php?id=<?= (int) $request['id'] ?>" class="btn btn-sm btn-ghost">Edit</a>
                                <button type="button" class="btn btn-sm btn-ghost" onclick="pdf_<?= (int) $request['id'] ?>.showModal()">Preview PDF</button>
                            </td>
                        </tr>

                        <dialog id="view_<?= (int) $request['id'] ?>" class="modal">
                            <div class="modal-box max-w-2xl">
                                <h3 class="text-lg font-bold mb-4">Visa Request #<?= (int) $request['id'] ?></h3>

                                <h4 class="font-semibold text-sm uppercase text-base-content/60 mb-2">Personal Information</h4>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4">
                                    <div><span class="text-sm text-base-content/60">Full Name</span><br><?= e($request['full_name']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Email Address</span><br><?= e($request['email']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Date of Birth</span><br><?= e($request['date_of_birth']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Return Confirmation</span><br>
                                        <?php if ($request['return_confirmation']): ?>
                                            <span class="badge badge-success badge-soft">Confirmed</span>
                                        <?php else: ?>
                                            <span class="badge badge-error badge-soft">Not confirmed</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="sm:col-span-2"><span class="text-sm text-base-content/60">Full Home Address</span><br><?= nl2br(e($request['home_address'])) ?></div>
                                </dl>

                                <h4 class="font-semibold text-sm uppercase text-base-content/60 mb-2">Church Information</h4>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-4">
                                    <div><span class="text-sm text-base-content/60">Church Name</span><br><?= e($request['church_name']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Pastor Name</span><br><?= e($request['pastor_name']) ?></div>
                                    <div class="sm:col-span-2"><span class="text-sm text-base-content/60">Church Address</span><br><?= nl2br(e($request['church_address'])) ?></div>
                                    <div><span class="text-sm text-base-content/60">Pastor Email Address</span><br><?= e($request['pastor_email']) ?></div>
                                </dl>

                                <h4 class="font-semibold text-sm uppercase text-base-content/60 mb-2">Passport / Consulate Information</h4>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div><span class="text-sm text-base-content/60">Passport Number</span><br><?= e($request['passport_number']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Passport Country</span><br><?= e($request['passport_country']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Passport Issue Date</span><br><?= e($request['passport_issue_date']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Passport Expiry Date</span><br><?= e($request['passport_expiry_date']) ?></div>
                                    <div><span class="text-sm text-base-content/60">Nearest British Embassy / Consulate</span><br><?= e($request['consulate_country']) ?></div>
                                </dl>

                                <div class="modal-action">
                                    <a href="/dashboard/visa/edit.php?id=<?= (int) $request['id'] ?>" class="btn btn-primary">Edit</a>
                                    <form method="dialog"><button class="btn">Close</button></form>
                                </div>
                            </div>
                            <form method="dialog" class="modal-backdrop"><button>close</button></form>
                        </dialog>

                        <dialog id="pdf_<?= (int) $request['id'] ?>" class="modal">
                            <div class="modal-box max-w-4xl h-[90vh]">
                                <h3 class="text-lg font-bold mb-4">Visa Letter Preview &mdash; <?= e($request['full_name']) ?></h3>
                                <iframe src="/dashboard/visa/pdf.php?id=<?= (int) $request['id'] ?>" class="w-full h-[75vh] border border-base-300 rounded"></iframe>
                                <div class="modal-action">
                                    <form method="dialog"><button class="btn">Close</button></form>
                                </div>
                            </div>
                            <form method="dialog" class="modal-backdrop"><button>close</button></form>
                        </dialog>
                    <?php endforeach; ?>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="7" class="text-center text-base-content/60">No visa requests yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../../../app/components/layout_end.php'; ?>
