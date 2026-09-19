<?php
/**
 * @var string $title
 * @var string $content Raw HTML body content.
 * @var string|null $actionsHtml
 */
$actionsHtml = $actionsHtml ?? null;
?>
<div class="card card-border bg-base-100 shadow-sm">
    <div class="card-body">
        <?php if (!empty($title)): ?>
            <h2 class="card-title"><?= App\Helpers\e($title) ?></h2>
        <?php endif; ?>
        <?= $content ?>
        <?php if ($actionsHtml): ?>
            <div class="card-actions justify-end"><?= $actionsHtml ?></div>
        <?php endif; ?>
    </div>
</div>
