<?php
/**
 * @var string $label
 * @var string|int $value
 * @var string|null $description
 */
$description = $description ?? null;
?>
<div class="card card-border bg-base-100 shadow-sm">
    <div class="card-body p-5">
        <span class="text-xs uppercase tracking-wide text-base-content/60"><?= App\Helpers\e($label) ?></span>
        <span class="text-3xl font-bold"><?= App\Helpers\e((string) $value) ?></span>
        <?php if ($description): ?>
            <span class="text-sm text-base-content/60"><?= App\Helpers\e($description) ?></span>
        <?php endif; ?>
    </div>
</div>
