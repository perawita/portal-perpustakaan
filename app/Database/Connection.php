<?php

namespace App\database;

use mysqli;

class Connection
{
    protected $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'db_perpustakaan';

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->conn->connect_errno) {
            die('Connection error: ' . $this->conn->connect_error);
        }

        /* Set the desired charset after establishing a connection */
        $this->conn->set_charset('utf8mb4');
        if ($this->conn->errno) {
            die('Error setting charset: ' . $this->conn->error);
        }
    }
}
