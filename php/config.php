<?php
$servername = "default";
$username = "default";
$password = "default";
$dbname = "default";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

