<?php
/**
 * Dashboard layout shell. Include this at the top of a protected page, then
 * echo content, then require layout_end.php.
 *
 * @var string $pageTitle
 * @var array<int, array{label: string, href?: string}> $breadcrumbs
 */
$breadcrumbs = $breadcrumbs ?? [];
?>
<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= App\Helpers\e($pageTitle ?? 'Dashboard') ?> &middot; Birmingham 2027</title>
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-base-200">
<div class="drawer lg:drawer-open">
    <input id="app-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content flex flex-col min-h-screen">
        <?php require __DIR__ . '/header.php'; ?>
        <main class="flex-1 p-4 lg:p-6 max-w-7xl w-full mx-auto">
            <?php require __DIR__ . '/breadcrumbs.php'; ?>
            <?php require __DIR__ . '/alerts.php'; ?>
