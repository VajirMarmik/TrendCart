<?php
$conn = new mysqli('localhost', 'root', '', 'vendor_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
