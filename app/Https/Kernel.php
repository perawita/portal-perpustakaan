<?php

namespace App\Https;

use App\Https\Middleware\Session as Session;

class Kernel
{
    public $session = [];
    public function __construct()
    {
        $this->session = new Session();
    }
}
