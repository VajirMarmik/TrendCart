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

$photo = $_FILES['photo']['name'];
$target_dir = "../uploads/products/";

// Check if the uploads directory exists, if not create it
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$photo_file = $target_dir . basename($photo);

// Upload the file
if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_file)) {
    // Insert product into the database
    $sql = "INSERT INTO product (vendor_id, product_name, description, price, category_id, brand_id, size, color, type, photo_path) 
            VALUES ($vendorId, '$productName', '$description', '$price', '$categoryId', '$brandId', '$productSize', '$productColor', '$productType', '$photo_file')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Error uploading the file.";
}

$conn->close();
?>
