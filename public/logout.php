<?php

require __DIR__ . '/../app/bootstrap.php';

use App\Auth\Auth;

Auth::logout();

App\Helpers\redirect('/login.php');
