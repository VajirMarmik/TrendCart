<?php
session_start();

// Check if the ID is set in the query string
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]); // Remove the item from the cart
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit; 
?>
