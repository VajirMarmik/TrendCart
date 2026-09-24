<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// add_brand.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brandName = $_POST['brand'];

    // Validate the brand name
    if (!preg_match('/^[A-Za-z\s-]+$/', $brandName)) {
        // Invalid brand name
        header("Location: brand.php?status=error");
        exit();
    }

    // Check if the brand already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM brands WHERE name = ?");
    $stmt->bind_param("s", $brandName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Redirect with error status if brand already exists
        header("Location: brand.php?status=duplicate");
        exit();
    }

    // Prepare and execute SQL query to add brand
    $stmt = $conn->prepare("INSERT INTO brands (name) VALUES (?)");
    $stmt->bind_param("s", $brandName);

    if ($stmt->execute()) {
        // Redirect with success status
        header("Location: brand.php?status=success");
    } else {
        // Redirect with error status
        header("Location: brand.php?status=error");
    }

    $stmt->close();
}

$conn->close();
?>
