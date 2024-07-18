<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Routes/api.php';
$session = (new App\Https\Kernel())->session;
