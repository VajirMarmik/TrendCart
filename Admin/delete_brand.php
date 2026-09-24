<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Get the brand ID from the query string
$brandId = $_GET['id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
$stmt->bind_param("i", $brandId);

// Execute the statement
if ($stmt->execute()) {
    echo "Brand deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

// Redirect back to brand page
header("Location: brand.php?status=deleted");
exit();
?>
