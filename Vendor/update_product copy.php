<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Fetch POST data
$productId = $_POST['product_id'];
$productName = $_POST['product_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$categoryId = $_POST['categorySelect'];
$brandId = $_POST['brandSelect'];
$productSize = $_POST['product_size'];
$productColor = $_POST['product_color'];
$productType = $_POST['product_type'];

// Prepare and execute the update query
$sql = "UPDATE product SET product_name = ?, description = ?, price = ?, category_id = ?, brand_id = ?, size = ?, color = ?, type = ?, status = 'pending' WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssdiiissi', $productName, $description, $price, $categoryId, $brandId, $productSize, $productColor, $productType, $productId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Product updated successfully!']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update product.']);
}

$stmt->close();
$conn->close();
?>
