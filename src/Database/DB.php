<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class DB
{
    private PDO $conn;

    public function __construct($host, $dbname, $userName, $password)
    {
        try {
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $userName, $password);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "</br>";
            die();
        }

    }

    public function exec(string $query)
    {
        return $this->conn->query($query);
    }
}
