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
    <!-- jQuery (necessary for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .btn .tooltip-text {
            visibility: hidden;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 16px;
        }

        .btn:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-generate-report {
            background-color: #28a745;
            border-color: #28a745;
            white-space: nowrap; /* Prevents text from wrapping */
            padding: 0.5rem 1rem; /* Adjust padding as needed */
            font-size: 1rem; /* Adjust font size if necessary */
        }

        .btn-generate-report:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include "admin_sidebar.php"; ?>
    <div class="main p-3">
        <div class="text-center">
            <h1 style="font-size: 30px;">Welcome to Admin</h1>
        </div>

        <div class="container mt-3">
            <?php include "dashboard_min.php"; ?>
