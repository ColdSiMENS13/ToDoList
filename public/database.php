<?php
class DataBase
{
    private $conn;
    public function __construct($hostName, $userName, $password, $database)
    {
        $this->conn = new mysqli($hostName, $userName, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

    }
    public function exec(string $query){
        return $this->conn->query($query);
    }
}
?>