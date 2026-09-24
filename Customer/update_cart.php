<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the cart index, new quantity, and total price from the request
    $index = isset($_POST['index']) ? intval($_POST['index']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $totalPrice = isset($_POST['totalPrice']) ? floatval($_POST['totalPrice']) : 0;

    // Update the session cart
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;
        $_SESSION['cart'][$index]['totalPrice'] = $totalPrice;
    }

    // Recalculate the total amount for all items in the cart
    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalAmount += $item['totalPrice'];
    }

    // Return the new total amount as JSON
    echo json_encode(['status' => 'success', 'totalAmount' => $totalAmount]);
}
?>
