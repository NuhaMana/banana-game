<?php
$host = "127.0.0.1";
$port = 4306;
$user = "root";
$pass = "";
$dbname = "banana_game";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>