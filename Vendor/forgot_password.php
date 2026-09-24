<?php
include "db.php";

// Include PHPMailer classes
include "PHPMailer/PHPMailer.php";
include "PHPMailer/SMTP.php";
include "PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $resetLink, $full_name) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'trendcarts2024@gmail.com'; // Replace with your email
        $mail->Password   = 'woyy umkj bsgc qinq';   // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('trendcarts2024@gmail.com', 'Trend Cart');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        // $mail->Subject = 'TrendCart - Reset Your Password';
        // $mail->Body    = "Dear $full_name,<br><br>
        //     We received a request to reset the password for your account associated with this email. If you made this request, click the link below to reset your password: <br><br>
        //     <a href='$resetLink'>Reset Password</a><br><br>
        //     If you did not request a password reset, please ignore this email or contact our support team if you have concerns.<br><br>
        //     <b>Vendor Support Team</b><br>
        //     +91 88661 72158<br>trendcarts2024@gmail.com<br><a href='http://localhost/tc1/Vendor/'>Visit TrendCart</a><br><br>
        //     <b>Regards,<br>
        //     TrendCart Team</b>";

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
                            <a href='$resetLink' 
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
                                <li><strong>Website:</strong> <a href='http://localhost/tc1/Vendor/'>Visit TrendCart</a></li>
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
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id, full_name FROM vendors WHERE email = ? AND is_verified = 'Joined'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $full_name);
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->fetch(); // Fetch the results into $id and $full_name

        // Email exists, generate reset token
        $token = bin2hex(random_bytes(50));
        $resetLink = "http://localhost/tc1/vendor/reset_password.php?token=" . $token;

        // Update the database with the reset token and set reset_status to 'not reset'
        $updateStmt = $conn->prepare("UPDATE vendors SET reset_token = ?, reset_status = 'not reset' WHERE email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        $updateStmt->execute();

        // Send the reset link via email
        if (sendMail($email, $resetLink, $full_name)) {
            $success = "<h4 style='color: green;'>A reset password link has been sent to your email address.</h4>";
        } else {
            $error = "Failed to send the reset link. Please try again later.";
        }
    } else {
        $error = "No account found with that email address.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Vendor Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #c96161, #5a59b9);
            margin: 0;
        }

        .login-container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #755656;
            border-radius: .35rem;
            padding: 1.5rem;
            background-color: #1c272a;
            box-shadow: 2px 4px 11px -1px #3f2e2e;
        }

        .login-container h1 {
            margin-top: 10px;
            color: #7FFFD4;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-container input.input-error {
            border-color: red;
        }

        .login-container input.input-success {
            border-color: green;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: #11ce1b;
            color: #000;
            border: 1.5px solid white;
            box-shadow: 0 0 0 1.5px white, 0 0 0 3px blue;
            font-size: 18px;
            margin-top: 10px;
        }

        .login-container .error {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
            color: #7FFFD4;
        }

        .logo {
            width: 75px;
            height: auto;
            box-shadow: 10px 7px 20px green;
            margin-bottom: 10px;
        }

        .input1 {
            display: block;
            width: 100%;
            padding: 0.75rem;
            background-color: #444;
            color: white;
            border: 1px solid #4a4747;
            margin-bottom: 2rem;
            font-size: 20px;
            margin-top: 1rem;
        }

        label {
            color: white;
        }

        .forgot-password-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .forgot-password-container .link1 {
            color: #007BFF;
            text-decoration: none;
        }

        .forgot-password-container .link1:hover {
            text-decoration: underline;
        }

        .alert-close a {
            color: #FFFFFF; /* Replace #FF5733 with the color you prefer */
            text-decoration: none; /* Optional: To remove underline if present */
            font-size: 25px; /* Sets the size to 5px */
        }

        .alert-close a:hover {
            color:#11ce1b; /* Optional: Change color on hover */
            font-size: 30px;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login-container">
        <div class="alert-close">
            <a href="index.php">
                <span class="fa fa-home"></span>
            </a>
        </div>
        <div class="text-center mb-4">
            <img src="logo.png" alt="TrendCart Logo" class="logo">
            <h1>Forgot Password</h1>          
        </div>

        <form method="POST" action="" onsubmit="return validate_form();">
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <?php if (isset($success)) { echo "<p class='success'>$success</p>"; } ?>
        
            <label for="email">E-Mail *</label>
            <input type="email" class="input1" id="email" name="email" placeholder="Email" oninput="validate_email()">
            <div id="email-error" class="error"></div>

            <button type="submit">Send Reset Password Link</button>

            <div class="forgot-password-container">
                <a href="login.php" class="link1">Back to Login</a>
            </div>
        </form>
    </div>

    <script>
        function validate_email() {
            var emailField = document.getElementById("email");
            var emailError = document.getElementById("email-error");
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (emailField.value === "") {
                emailError.innerHTML = "E-Mail cannot be empty";
                emailField.classList.add("input-error");
                emailField.classList.remove("input-success");
                return false;
            } else if (!emailField.value.match(emailPattern)) {
                emailError.innerHTML = "Please enter a valid email address";
                emailField.classList.add("input-error");
                emailField.classList.remove("input-success");
                return false;
            } else {
                emailError.innerHTML = "";
                emailField.classList.remove("input-error");
                emailField.classList.add("input-success");
                return true;
            }
        }

        function validate_form() {
            var validEmail = validate_email();
        }
    </script>
</body>
</html>
