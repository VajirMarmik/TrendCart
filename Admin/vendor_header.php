<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";
include "PHPMailer/PHPMailer.php";
include "PHPMailer/SMTP.php";
include "PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Delete unverified vendors older than 48 Hours
$deletion_query = "DELETE FROM `vendors` WHERE `verification_status` != 'Verified' AND `created_at` < (NOW() - INTERVAL 48 HOUR)";
mysqli_query($conn, $deletion_query);

// Delete Subscription Planwise vendors older
$deletion_query = "
    DELETE FROM `vendors`
    WHERE 
        (`make_plan` = 'Free' AND `created_at` < (NOW() - INTERVAL 7 DAY))
        OR (`make_plan` = 'Basic' AND `created_at` < (NOW() - INTERVAL 3 MONTH))
        OR (`make_plan` = 'Standard' AND `created_at` < (NOW() - INTERVAL 7 MONTH))
        OR (`make_plan` = 'Premium' AND `created_at` < (NOW() - INTERVAL 1 YEAR))
";
mysqli_query($conn, $deletion_query);

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($startDate && !$endDate) {
    $endDate = date('Y-m-d'); // Set endDate to today's date if not provided
}

// Handle verification status change
if (isset($_POST['verify_vendor'])) {
    $vendor_id = $_POST['vendor_id'];
    $new_status = $_POST['verification_status'];

    // Generate a unique verification code if verifying the vendor
    $v_code = bin2hex(random_bytes(16));

    // Fetch vendor details (email, full name, and other fields)
    $vendor_query = "
        SELECT `email`, `full_name`, `username`, `phone`, `pancard_number`, `upi_id`, `make_plan` AS `subscription_plan`
        FROM `vendors`
        WHERE `id` = '$vendor_id'
    ";
    $vendor_result = mysqli_query($conn, $vendor_query);
    $vendor = mysqli_fetch_assoc($vendor_result);

    if ($vendor) {
        $email = $vendor['email'];
        $full_name = $vendor['full_name'];
        $username = $vendor['username'];
        $phone = $vendor['phone'];
        $pan_card_number = $vendor['pancard_number'];
        $upi_id = $vendor['upi_id'];
        $subscription_plan = $vendor['subscription_plan'];

        // Update the verification status in the database
        $update_query = "UPDATE `vendors` SET `verification_status` = '$new_status', `verification_code` = '$v_code' WHERE `id` = '$vendor_id'";
        mysqli_query($conn, $update_query);

        // Send verification email if status is updated to verified
        if ($new_status === 'Verified') {
            sendMail($email, $v_code, $full_name, $username, $phone, $pan_card_number, $upi_id, $subscription_plan);
            echo "<script>alert('Vendor verified and verification email sent.');</script>";
        } else {
            echo "<script>alert('Vendor status updated but not verified.');</script>";
        }
    } else {
        echo "<script>alert('Vendor not found.');</script>";
    }

    header("Location: vendor.php");
    exit();
}

// Function to send email
function sendMail($email, $v_code, $full_name, $username, $phone, $pan_card_number, $upi_id, $subscription_plan) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'trendcarts2024@gmail.com';
        $mail->Password   = 'woyy umkj bsgc qinq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('trendcarts2024@gmail.com', 'Trend Cart');
        $mail->addAddress($email);

        $mail->isHTML(true);
        // $mail->Subject = 'TrendCart - Registration Email Verification';
        // $mail->Body    = "
        //     Dear $full_name,<br><br>
        //     Thank you for registering with TrendCart! We're thrilled to have you on board as one of our valued vendors.<br><br>
        //     Here are the details of your registration:<br>
        //     <strong>Full Name:</strong> $full_name<br>
        //     <strong>Username:</strong> $username<br>
        //     <strong>Phone:</strong> $phone<br>
        //     <strong>Email:</strong> $email<br>
        //     <strong>PAN Card Number:</strong> $pan_card_number<br>
        //     <strong>UPI ID:</strong> $upi_id<br>
        //     <strong>Selected Subscription Plan:</strong> $subscription_plan<br><br>
        //     Please verify your email address to complete the registration process : 
        //     <a href='http://localhost/tc1/vendor/verify.php?email=$email&v_code=$v_code'>Verify Email</a><br><br>
        //     If any of the above information is incorrect, please contact us immediately at 
        //     <b>Vendor Support Team</b><br>
        //     +91 88661 72158<br>trendcarts2024@gmail.com<br><a href='http://localhost/tc1/Vendor/'>Visit TrendCart</a><br><br>
        //     <b>Regards,<br>
        //     TrendCart Team</b>
        // ";

        // $mail->Subject = 'Welcome to TrendCart - Registration Email Verification';
        // $mail->Body = "
        //     <html>
        //     <head>
        //         <style>
        //             body {
        //                 font-family: Arial, sans-serif;
        //                 line-height: 1.6;
        //             }
        //             .content {
        //                 padding: 20px;
        //                 background-color: #f9f9f9;
        //                 border: 1px solid #ddd;
        //                 border-radius: 10px;
        //             }
        //             .header {
        //                 color: #333;
        //                 font-size: 18px;
        //                 margin-bottom: 10px;
        //             }
        //             .footer {
        //                 margin-top: 20px;
        //                 font-size: 14px;
        //                 color: #666;
        //             }
        //             .cta {
        //                 display: inline-block;
        //                 padding: 10px 20px;
        //                 background-color: #007bff;
        //                 color: #fff;
        //                 text-decoration: none;
        //                 border-radius: 5px;
        //                 font-weight: bold;
        //             }
        //         </style>
        //     </head>
        //     <body>
        //         <div class='content'>
        //             <p class='header'>Dear $full_name,</p>
        //             <p>Thank you for joining TrendCart! We are excited to welcome you as a valued vendor on our platform.</p>
        //             <p>Here are the details of your registration:</p>
        //             <ul>
        //                 <li><strong>Full Name:</strong> $full_name</li>
        //                 <li><strong>Username:</strong> $username</li>
        //                 <li><strong>Phone:</strong> $phone</li>
        //                 <li><strong>Email:</strong> $email</li>
        //                 <li><strong>PAN Card Number:</strong> $pan_card_number</li>
        //                 <li><strong>UPI ID:</strong> $upi_id</li>
        //                 <li><strong>Selected Subscription Plan:</strong> $subscription_plan</li>
        //             </ul>
        //             <p>To complete your registration, please verify your email address by clicking the button below:</p>
        //             <p><a href='http://localhost/tc1/vendor/verify.php?email=$email&v_code=$v_code' class='cta'>Verify Email</a></p>
        //             <p>If any of the above information is incorrect, please contact our Vendor Support Team immediately.</p>
        //             <p>Contact us:</p>
        //             <ul>
        //                 <li><strong>Phone:</strong> +91 88661 72158</li>
        //                 <li><strong>Email:</strong> <a href='mailto:trendcarts2024@gmail.com'>trendcarts2024@gmail.com</a></li>
        //                 <li><strong>Website:</strong> <a href='http://localhost/tc1/Vendor/'>Visit TrendCart</a></li>
        //             </ul>
        //             <p class='footer'>Warm regards,<br><b>TrendCart Team</b></p>
        //         </div>
        //     </body>
        //     </html>
        // ";

        $mail->Subject = 'Welcome to TrendCart - Registration Email Verification';

        $currentYear = date('Y'); // Fetch the current year dynamically
        $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 30px auto;
                        background-color: #ffffff;
                        border: 1px solid #eaeaea;
                        border-radius: 8px;
                        overflow: hidden;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
                    .email-header {
                        background-color: #1a73e8;
                        color: #ffffff;
                        padding: 20px;
                        text-align: center;
                        font-size: 24px;
                        font-weight: bold;
                    }
                    .email-body {
                        padding: 20px;
                        color: #333333;
                        line-height: 1.6;
                    }
                    .email-body p {
                        margin: 10px 0;
                    }
                    .email-body ul {
                        padding-left: 20px;
                        margin: 10px 0;
                    }
                    .email-body ul li {
                        margin: 5px 0;
                    }
                    .verify-button {
                        display: inline-block;
                        padding: 10px 20px;
                        margin: 20px 0;
                        background-color: #1a73e8; /* Blue background */
                        color: #ffffff; /* White text */
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                        font-weight: bold;
                    }
                    .contact-info {
                        margin: 20px 0;
                    }
                    .contact-info ul {
                        padding-left: 20px;
                    }
                    .contact-info ul li {
                        margin: 5px 0;
                    }
                    .email-footer {
                        text-align: center;
                        padding: 15px;
                        background-color: #f1f1f1;
                        color: #666666;
                        font-size: 14px;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        Welcome to TrendCart
                    </div>
                    <div class='email-body'>
                        <p>Dear $full_name,</p>
                        <p>Thank you for joining TrendCart! We are thrilled to have you as a vendor on our platform.</p>
                        <p><b>Your Registration Details:</b></p>
                        <ul>
                            <li><strong>Full Name:</strong> $full_name</li>
                            <li><strong>Username:</strong> $username</li>
                            <li><strong>Phone:</strong> $phone</li>
                            <li><strong>Email:</strong> $email</li>
                            <li><strong>PAN Card Number:</strong> $pan_card_number</li>
                            <li><strong>UPI ID:</strong> $upi_id</li>
                            <li><strong>Selected Subscription Plan:</strong> $subscription_plan</li>
                        </ul>
                        <p>To complete your registration, please verify your email by clicking the button below:</p>
                        <p style='text-align: center;'>
                            <a href='http://localhost/tc1/vendor/verify.php?email=$email&v_code=$v_code' 
                            style='display: inline-block; padding: 10px 20px; background-color: #1a73e8; color: #ffffff; 
                                    text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;'>
                                Verify Email
                            </a>
                        </p>
                        <p>If any of the above information is incorrect, please contact our Vendor Support Team immediately.</p>
                        <div class='contact-info'>
                            <p><b>Contact Us:</b></p>
                            <ul>
                                <li><strong>Phone:</strong> +91 88661 72158</li>
                                <li><strong>Email:</strong> <a href='mailto:trendcarts2024@gmail.com'>trendcarts2024@gmail.com</a></li>
                                <li><strong>Website:</strong> <a href='http://localhost/tc1/Vendor/'>Visit TrendCart</a></li>
                            </ul>
                        </div>
                        <p>We look forward to a successful partnership!</p>
                        <p>Warm regards,</p>
                        <p><b>TrendCart Team</b></p>
                    </div>
                    <div class='email-footer'>
                        &copy; " . $currentYear . " TrendCart. All Rights Reserved.
                    </div>
                </div>
            </body>
            </html>
        ";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Manage Vendors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .download-btn {
            float: right;
            margin: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .verify-btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
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
            
            <?php  include "dashboard_min.php"; ?>