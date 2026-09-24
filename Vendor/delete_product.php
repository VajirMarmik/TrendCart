<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

include "db.php";

// Get the vendor ID
$vendorUsername = $_SESSION['username'];
$vendorQuery = "SELECT id FROM vendors WHERE username = '$vendorUsername'";
$vendorResult = $conn->query($vendorQuery);
$vendorRow = $vendorResult->fetch_assoc();
$vendorId = $vendorRow['id'];

// Collect data from POST request
$productId = mysqli_real_escape_string($conn, $_POST['product_id']);

// Delete product from the database
$sql = "DELETE FROM product WHERE product_id = $productId AND vendor_id = $vendorId";
if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
