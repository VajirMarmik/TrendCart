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

    // Ensure status is either 'verified' or 'not_verified'
    if ($status === 'verified' || $status === 'not_verified') {
        $sql = "UPDATE product SET status = ? WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status, $productId);

        if ($stmt->execute()) {
            echo "Product status updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid status";
    }
}

$conn->close();
?>
