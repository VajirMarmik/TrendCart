<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
// if (isset($_SESSION['SESSION_EMAIL'])) {
//     header("Location: index.php");
//     die();
// }

require 'vendor/autoload.php';
include 'db.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $code = mysqli_real_escape_string($conn, md5(rand()));

    // Check if email already exists
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM customer WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
    } else {
        if ($password === $confirm_password) {
            // Insert user without profile photo
            $sql = "INSERT INTO customer (full_name, phone, email, password, code) VALUES ('{$name}', '{$phone}', '{$email}', '{$password}', '{$code}')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div style='display: none;'>";
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
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
                    // $mail->Subject = 'Register';
                    // $mail->Body    = 'Here is the verification link <b><a href="http://localhost/tc1/Customer/login.php?verification='.$code.'">http://localhost/tc1/Customer/login.php?verification='.$code.'</a></b>';

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
                                        <p>Dear $name,</p>
                                        <p>Thank you for joining TrendCart! We are thrilled to have you as a customer on our platform.</p>
                                        <p><b>Your Registration Details:</b></p>
                                        <ul>
                                            <li><strong>Full Name:</strong> $name</li>
                                            <li><strong>Phone:</strong> $phone</li>
                                            <li><strong>Email:</strong> $email</li>
                                        </ul>
                                        <p>To complete your registration, please verify your email by clicking the button below:</p>
                                        <p style='text-align: center;'>
                                            <a href='http://localhost/tc1/Customer/login.php?verification='.$code.'' 
                                            style='display: inline-block; padding: 10px 20px; background-color: #1a73e8; color: #ffffff; 
                                                    text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;'>
                                                Verify Email
                                            </a>
                                        </p>
                                        <p>If any of the above information is incorrect, please contact our Customer Support Team immediately.</p>
                                        <div class='contact-info'>
                                            <p><b>Contact Us:</b></p>
                                            <ul>
                                                <li><strong>Phone:</strong> +91 88661 72158</li>
                                                <li><strong>Email:</strong> <a href='mailto:trendcarts2024@gmail.com'>trendcarts2024@gmail.com</a></li>
                                                <li><strong>Website:</strong> <a href='http://localhost/tc1/Customer/'>Visit TrendCart</a></li>
                                            </ul>
                                        </div>
                                        <p>We look forward to a customers!</p>
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
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Login Form - Brave Coder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="w3l-mockup-form">
        <div class="container">
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="content-wthree">
                        <h2>Register Now</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="text" class="phone" name="phone" placeholder="Enter Your Phone Number" value="<?php if (isset($_POST['submit'])) { echo $phone; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                            <button name="submit" class="btn" type="submit">Register</button>
                        </form>
                        <div class="social-icons">
                            <p>Have an account! <a href="login.php">Login</a>.</p>
                        </div>
                    </div>
                    <div class="alert-close">
                        <span class="fa fa-home"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                window.location.href = 'index.php';
            });
        });
    </script>
</body>
</html>
