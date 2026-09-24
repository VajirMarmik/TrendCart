<?php
$conn = new mysqli('localhost', 'root', '', 'vendor_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<link rel="shortcut icon" type="x-icon" href="logo.png">