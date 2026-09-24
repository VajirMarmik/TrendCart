<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['productId'];
    $status = $_POST['status'];

    $sql = "UPDATE product SET status = ? WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $productId);

    if ($stmt->execute()) {
        echo "Product status updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
