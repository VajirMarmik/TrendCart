<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Get the category ID from the query string
$categoryId = $_GET['id'];

// Prepare and bind
$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $categoryId);

// Execute the statement
if ($stmt->execute()) {
    echo "Category deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();

// Redirect back to category page
header("Location: category.php");
exit();
?>
