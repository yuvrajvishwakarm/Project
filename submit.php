<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_name";
$conn = new mysqli("localhost", "root", "password", "database_name");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
