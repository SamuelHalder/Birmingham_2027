<?php

use App\Auth\Auth;
use App\Auth\Roles;

$user = Auth::user();
?>
<div class="navbar bg-base-100 border-b border-base-300 sticky top-0 z-20">
    <div class="flex-none lg:hidden">
        <label for="app-drawer" aria-label="Open sidebar" class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </label>
    </div>
    <div class="flex-1">
        <span class="text-lg font-semibold lg:hidden">Birmingham 2027</span>
    </div>
    <div class="flex-none">
        <?php if ($user): ?>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost">
                    <span><?= App\Helpers\e($user['name']) ?></span>
                    <span class="badge badge-sm badge-outline"><?= App\Helpers\e(Roles::label($user['role'])) ?></span>
                </div>
                <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box z-30 mt-3 w-48 p-2 shadow">
                    <li><a href="/logout.php">Log out</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
