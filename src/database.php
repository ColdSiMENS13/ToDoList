<?php
class DataBase
{
    private $conn;
    public function __construct($userName, $password)
    {
        try {
            $this->conn = new PDO('mysql:host=mysql;dbname=example', $userName, $password);
}
catch (PDOException $e) {
            print "Error!: ". $e->getMessage(). "</br>";
            die();
}

    }
    public function exec(string $query){
        return $this->conn->query($query);
    }
}
?>