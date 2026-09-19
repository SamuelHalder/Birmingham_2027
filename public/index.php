<?php

require __DIR__ . '/../app/bootstrap.php';

use App\Auth\Auth;

App\Helpers\redirect(Auth::check() ? '/dashboard/' : '/login.php');
