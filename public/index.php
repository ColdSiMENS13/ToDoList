<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

use App\Bootstrap;

require_once '../vendor/autoload.php';

(new Bootstrap())->run();


