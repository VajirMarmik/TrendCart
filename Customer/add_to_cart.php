<!-- add_to_cart.php -->

<?php
session_start();

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product details from the POST request
    $productId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $productName = isset($_POST['name']) ? $_POST['name'] : '';
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
    $totalPrice = isset($_POST['totalPrice']) ? (float)$_POST['totalPrice'] : 0;

    // Fetch additional product details from the database
    include 'db.php'; // Include the database connection
    $query = "SELECT description, size, color, type, photo_path FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $productDetails = $result->fetch_assoc();
    
    // Close the database connection
    $stmt->close();
    $conn->close();

    // Check if the cart session variable is set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the product to the cart
    $_SESSION['cart'][] = [
        'id' => $productId,
        'name' => $productName,
        'price' => $price,
        'quantity' => $quantity,
        'totalPrice' => $totalPrice,
        // Add the additional product details
        'description' => $productDetails['description'],
        'size' => $productDetails['size'],
        'color' => $productDetails['color'],
        'type' => $productDetails['type'],
        'photo_path' => $productDetails['photo_path'], // Include the photo path
    ];

    // Send a response back to the client
    echo json_encode(['success' => true]);
} else {
    // Invalid request method
    echo json_encode(['success' => false]);
}
?>