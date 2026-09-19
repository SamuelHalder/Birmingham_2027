<?php
/**
 * @var array<int, array{label: string, href?: string}> $breadcrumbs
 */
$breadcrumbs = $breadcrumbs ?? [];
?>
<?php if (!empty($breadcrumbs)): ?>
<div class="breadcrumbs text-sm px-1">
    <ul>
        <?php foreach ($breadcrumbs as $crumb): ?>
            <li>
                <?php if (!empty($crumb['href'])): ?>
                    <a href="<?= App\Helpers\e($crumb['href']) ?>"><?= App\Helpers\e($crumb['label']) ?></a>
                <?php else: ?>
                    <?= App\Helpers\e($crumb['label']) ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
