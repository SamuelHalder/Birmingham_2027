<?php

require __DIR__ . '/../../app/bootstrap.php';

use App\Auth\User;
use function App\Middleware\requireLogin;

requireLogin();

$pageTitle = 'Dashboard';
$breadcrumbs = [['label' => 'Dashboard']];

$totalUsers = count(User::all());

require __DIR__ . '/../../app/components/layout_start.php';

$title = 'Dashboard';
$subtitle = 'Overview of the administration panel';
require __DIR__ . '/../../app/components/page_header.php';
?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <?php
    $label = 'Total Users';
    $value = $totalUsers;
    $description = 'Active and inactive';
    require __DIR__ . '/../../app/components/stat_card.php';

    $label = 'Registration';
    $value = '—';
    $description = 'Coming soon';
    require __DIR__ . '/../../app/components/stat_card.php';

    $label = 'Hotels';
    $value = '—';
    $description = 'Coming soon';
    require __DIR__ . '/../../app/components/stat_card.php';

    $label = 'Meals';
    $value = '—';
    $description = 'Coming soon';
    require __DIR__ . '/../../app/components/stat_card.php';
    ?>
</div>

<?php
$title = 'Welcome';
$content = '<p>This is the Birmingham 2027 Convention Administration Panel foundation. Convention modules will appear here as they are built.</p>';
require __DIR__ . '/../../app/components/card.php';
?>

<?php require __DIR__ . '/../../app/components/layout_end.php'; ?>
