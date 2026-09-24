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
$productName = mysqli_real_escape_string($conn, $_POST['product_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$categoryId = mysqli_real_escape_string($conn, $_POST['categorySelect']);
$brandId = mysqli_real_escape_string($conn, $_POST['brandSelect']);
$productSize = mysqli_real_escape_string($conn, $_POST['product_size']);
$productColor = mysqli_real_escape_string($conn, $_POST['product_color']);
$productType = mysqli_real_escape_string($conn, $_POST['product_type']);

// Insert product into the database
$sql = "INSERT INTO product (vendor_id, product_name, description, price, category_id, brand_id, size, color, type) 
        VALUES ($vendorId, '$productName', '$description', '$price', '$categoryId', '$brandId', '$productSize', '$productColor', '$productType')";
if ($conn->query($sql) === TRUE) {
    echo "Success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
