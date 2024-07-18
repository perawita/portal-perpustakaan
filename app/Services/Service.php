<?php

namespace App\Services;

use App\database\Connection;

use App\Models\Books as book;
use App\Models\Loans as loan;

class Service extends Connection
{
    protected $connection = null;
    protected $books = null;
    protected $loans = null;
    public function __construct()
    {
        parent::__construct(); //inisialisasi class koneksi
        $this->connection = $this->conn;
        $this->books = new book();
        $this->loans = new loan();
    }
}
