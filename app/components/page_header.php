<?php
/**
 * @var string $title
 * @var string|null $subtitle
 * @var string|null $actionsHtml Raw HTML for right-aligned actions (buttons etc.)
 */
$subtitle = $subtitle ?? null;
$actionsHtml = $actionsHtml ?? null;
?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
    <div>
        <h1 class="text-2xl font-bold"><?= App\Helpers\e($title) ?></h1>
        <?php if ($subtitle): ?>
            <p class="text-base-content/60 text-sm mt-1"><?= App\Helpers\e($subtitle) ?></p>
        <?php endif; ?>
    </div>
    <?php if ($actionsHtml): ?>
        <div class="flex gap-2">
            <?= $actionsHtml ?>
        </div>
    <?php endif; ?>
</div>
