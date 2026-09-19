<?php

/**
 * Sidebar navigation definition.
 * `implemented` => false renders a disabled/"soon" item instead of a link.
 */

use App\Auth\Auth;

$navSections = [
    [
        'items' => [
            ['label' => 'Dashboard', 'href' => '/dashboard/', 'icon' => 'home', 'implemented' => true],
        ],
    ],
    [
        'title' => 'Convention',
        'items' => [
            ['label' => 'Registration', 'href' => '#', 'icon' => 'clipboard', 'implemented' => false],
            ['label' => 'Participants', 'href' => '#', 'icon' => 'users', 'implemented' => false],
            ['label' => 'Hotels', 'href' => '#', 'icon' => 'building', 'implemented' => false],
            ['label' => 'Meals', 'href' => '#', 'icon' => 'utensils', 'implemented' => false],
            ['label' => 'Visa Letters', 'href' => '#', 'icon' => 'file', 'implemented' => false],
        ],
    ],
    [
        'title' => 'Management',
        'items' => [
            ['label' => 'Users', 'href' => '/dashboard/users/', 'icon' => 'user-cog', 'implemented' => true, 'role' => 'super_admin'],
        ],
    ],
    [
        'title' => 'Other',
        'items' => [
            ['label' => 'Reports', 'href' => '#', 'icon' => 'chart', 'implemented' => false],
            ['label' => 'Settings', 'href' => '#', 'icon' => 'cog', 'implemented' => false],
        ],
    ],
];

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
?>
<div class="drawer-side z-30">
    <label for="app-drawer" aria-label="Close sidebar" class="drawer-overlay"></label>
    <aside class="menu bg-base-200 min-h-full w-72 p-4 flex flex-col gap-1">
        <div class="px-2 py-3 mb-2">
            <span class="text-lg font-bold">Birmingham 2027</span>
            <p class="text-xs text-base-content/60">Convention Admin Panel</p>
        </div>

        <?php foreach ($navSections as $section): ?>
            <?php
            if (!empty($section['title'])) {
                echo '<li class="menu-title">' . App\Helpers\e($section['title']) . '</li>';
            }
            ?>
            <?php foreach ($section['items'] as $item): ?>
                <?php if (!empty($item['role']) && !Auth::hasRole($item['role'])): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <li>
                    <?php if ($item['implemented']): ?>
                        <a href="<?= App\Helpers\e($item['href']) ?>" class="<?= $currentPath === $item['href'] ? 'menu-active' : '' ?>">
                            <?= App\Helpers\e($item['label']) ?>
                        </a>
                    <?php else: ?>
                        <span class="menu-disabled text-base-content/40" aria-disabled="true">
                            <?= App\Helpers\e($item['label']) ?>
                            <span class="badge badge-ghost badge-xs ml-auto">soon</span>
                        </span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </aside>
</div>
