<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Manage Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .btn-icon {
            position: relative;
            display: inline-block;
        }

        .btn-icon .tooltip-text {
            visibility: hidden;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position the tooltip above the icon */
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 16px; /* Adjust the font size here */
        }

        .btn-icon:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <?php include "vendor_sidebar.php"; ?>

        <div class="main p-3">
            <div class="text-center">
                <h1 style="font-size: 30px;">
                    Welcome to <?php echo htmlspecialchars($_SESSION['username']); ?>
                </h1>
            </div>

            <div class="container mt-3">
                
                <?php  include "dashboard_min.php"; ?>
