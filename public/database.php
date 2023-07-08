<?php


$hostName = 'mysql';
$userName = 'example';
$password = 'example';
$database = 'example';

$conn = new mysqli($hostName, $userName, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
