<?php

session_start();

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'db.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    // Check if email exists
    $result = mysqli_query($conn, "SELECT full_name FROM customer WHERE email='{$email}'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); // Fetch user details
        $full_name = $row['full_name'];

        $query = mysqli_query($conn, "UPDATE customer SET code='{$code}' WHERE email='{$email}'");

        if ($query) {
            echo "<div style='display: none;'>";
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'trendcarts2024@gmail.com';
                $mail->Password   = 'woyy umkj bsgc qinq';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                //Recipients
                $mail->setFrom('trendcarts2024@gmail.com', 'Trend Cart');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);
            //     $mail->Subject = 'TrendCart - Reset Your Password';
            //     $mail->Body = "Dear $full_name,<br><br>
            //         We received a request to reset the password for your account associated with this email. If you made this request, click the link below to reset your password: <br><br>
            //         <b><a href='http://localhost/tc1/Customer/change-password.php?reset=$code'>Reset Password</a></b><br><br>
            //         If you did not request a password reset, please ignore this email or contact our support team if you have concerns.<br><br>
            //         <b>Customer Support Team</b><br>
            //         +91 88661 72158<br>trendcarts2024@gmail.com<br><a href='http://localhost/tc1/Customer/'>Visit TrendCart</a><br><br>
            // Regards,<br>
            // TrendCart Team";

            $mail->Subject = 'TrendCart - Reset Your Password';
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
                        .reset-button {
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
                            Reset Your Password
                        </div>
                        <div class='email-body'>
                            <p>Dear $full_name,</p>
                            <p>We received a request to reset the password for your account associated with this email. If you made this request, please click the button below to reset your password:</p>
                            <p style='text-align: center;'>
                                <a href='http://localhost/tc1/Customer/change-password.php?reset=$code'' 
                                style='display: inline-block; padding: 10px 20px; background-color: #1a73e8; 
                                        color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;'>
                                    Reset Password
                                </a>
                            </p>
                            <p>If you did not request a password reset, please ignore this email or contact our support team if you have concerns.</p>
                            <div class='contact-info'>
                                <p><b>Contact Us:</b></p>
                                <ul>
                                    <li><strong>Phone:</strong> +91 88661 72158</li>
                                    <li><strong>Email:</strong> <a href='mailto:trendcarts2024@gmail.com'>trendcarts2024@gmail.com</a></li>
                                    <li><strong>Website:</strong> <a href='http://localhost/tc1/Customer/'>Visit TrendCart</a></li>
                                </ul>
                            </div>
                            <p>Warm regards,</p>
                            <p><b>TrendCart Team</b></p>
                        </div>
                        <div class='email-footer'>
                            &copy; " . date('Y') . " TrendCart. All rights reserved.
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
        }
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address was not found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login Form - Brave Coder</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" crossorigin="anonymous"></script>

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-home"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image3.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Forgot Password</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                            <button name="submit" class="btn" type="submit">Send Reset Link</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="login.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                window.location.href = 'index.php'; // Redirect to index.php on close
            });
        });
    </script>
</body>

</html>