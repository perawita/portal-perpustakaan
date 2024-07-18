<?php

namespace App\Https\Controllers;

use App\Models\Books as book;
use App\Models\Categories as categori;

use App\Models\Users as user;

use App\Models\Loans as loan;

use App\Https\Middleware\Session as session;


class Controller
{
    protected $books = null;
    protected $categories = null;
    protected $users = null;
    protected $loans = null;
    protected $session = null;

    public function __construct()
    {
        $this->books = new book();
        $this->categories = new categori();
        $this->users = new user();
        $this->session = new session();
        $this->users = new user();
        $this->loans = new loan();
    }
}
