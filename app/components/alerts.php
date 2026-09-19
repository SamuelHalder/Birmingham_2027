<?php
/**
 * Renders flashed messages from the session (set via App\Helpers\flash()).
 */
$flashTypeMap = [
    'success' => 'alert-success',
    'error' => 'alert-error',
    'warning' => 'alert-warning',
    'info' => 'alert-info',
];
?>
<?php foreach (App\Helpers\get_flashes() as $flash): ?>
    <div role="alert" class="alert <?= $flashTypeMap[$flash['type']] ?? 'alert-info' ?> mb-4">
        <span><?= App\Helpers\e($flash['message']) ?></span>
    </div>
<?php endforeach; ?>
