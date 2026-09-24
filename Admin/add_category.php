<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// add_category.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['category'];

    // Validate the category name
    if (!preg_match('/^[A-Za-z\s-]+$/', $categoryName)) {
        // Invalid category name
        header("Location: category.php?status=error");
        exit();
    }

    // Check if the category already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Redirect with error status if category already exists
        header("Location: category.php?status=duplicate");
        exit();
    }

    // Prepare and execute SQL query to add category
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $categoryName);

    if ($stmt->execute()) {
        // Redirect with success status
        header("Location: category.php?status=success");
    } else {
        // Redirect with error status
        header("Location: category.php?status=error");
    }

    $stmt->close();
}

$conn->close();
?>
