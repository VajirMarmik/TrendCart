<?php
include "db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate inputs
    if (empty($email) || empty($new_password) || empty($confirm_password)) {
        echo "All fields are required!";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT email FROM vendors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Email does not exist
        header("Location: register.php"); // Redirect immediately
        exit();
    }
    
    // Encrypt the password using a stronger method like bcrypt
    $encrypted_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Prepare and bind the SQL statement to update the password
    $stmt = $conn->prepare("UPDATE vendors SET password=? WHERE email=?");
    $stmt->bind_param("ss", $encrypted_password, $email);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: login.php"); // Redirect immediately to login page
        exit();
    } else {
        echo "Error updating password: " . $conn->error;
    }

    // Close the statement and connection
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
            background: #f0f0f0;
            margin: 0;
            background: linear-gradient(to right, #c96161, #5a59b9);
        }

        .forgot-container {
            width: 300px;
            margin: 0 auto;
            border: 1px solid #755656;
            border-radius: .35rem;
            padding: 1.5rem;
            background-color: #1c272a;
            box-shadow: 2px 4px 11px -1px #3f2e2e;
        }

        .forgot-container h1 {
            margin-top: 10px;
            color: #7FFFD4; /* Set color for header text */
        }

        .forgot-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .forgot-container input.input-error {
            border-color: red;
        }

        .forgot-container input.input-success {
            border-color: green;
        }

        .forgot-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            margin-top: 10px;
        }

        .forgot-container button:hover {
            background-color: #11ce1b; /* Green background color */
            color: #000; /* Black font color */
            border: 1.5px solid white; /* White border */
            box-shadow: 0 0 0 1.5px white, 0 0 0 3px blue; /* White and blue shadow effect */
            font-size: 18px;
            margin-top: 10px;
        }

        .forgot-container .error {
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

        .back-login-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .back-login-container .link {
            color: #007BFF;
            text-decoration: none;
        }

        .back-login-container .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="text-center mb-4">
            <img src="logo.png" alt="TrendCart Logo" class="logo">
            <h1>Forgot Password</h1>          
        </div>

        <form method="POST" action="" onsubmit="return validate_forgot_password_form()">
            <div>
                <label for="email">Email *</label>
                <input type="email" class="input1" id="email" name="email" placeholder="Email" oninput="validate_email()">
                <span id="email-error" class="error"></span>
            </div>

            <div>
                <label for="new-password">New Password *</label>
                <input type="password" class="input1" id="new-password" name="new-password" placeholder="New Password" oninput="validate_passwords()">
                <span id="new-password-error" class="error"></span>
            </div>

            <div>
                <label for="confirm-password">Confirm Password *</label>
                <input type="password" class="input1" id="confirm-password" name="confirm-password" placeholder="Confirm Password" oninput="validate_passwords()">
                <span id="confirm-password-error" class="error"></span>
            </div>
            <button type="submit">Update Password</button>

            <div class="back-login-container">
                <a href="login.php" class="link">Back to Login</a>
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

        function validate_passwords() {
            var newPasswordF = document.getElementById("new-password");
            var confirmPasswordF = document.getElementById("confirm-password");
            var newPasswordE = document.getElementById("new-password-error");
            var confirmPasswordE = document.getElementById("confirm-password-error");

            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,14}$/;

            if (newPasswordF.value === "") {
                newPasswordE.innerHTML = "Enter new password";
                newPasswordF.classList.add("input-error");
                newPasswordF.classList.remove("input-success");
                return false;
            } else if (!newPasswordF.value.match(passwordPattern)) {
                newPasswordE.innerHTML = "Password must be 8-14 characters long and include at least one lowercase letter, one uppercase letter, one number, and one special character";
                newPasswordF.classList.add("input-error");
                newPasswordF.classList.remove("input-success");
                return false;
            } else if (newPasswordF.value !== confirmPasswordF.value) {
                confirmPasswordE.innerHTML = "Passwords do not match";
                confirmPasswordF.classList.add("input-error");
                confirmPasswordF.classList.remove("input-success");
                return false;
            } else {
                newPasswordE.innerHTML = "";
                confirmPasswordE.innerHTML = "";
                newPasswordF.classList.remove("input-error");
                confirmPasswordF.classList.remove("input-error");
                newPasswordF.classList.add("input-success");
                confirmPasswordF.classList.add("input-success");
                return true;
            }
        }

        function validate_forgot_password_form() {
            var validEmail = validate_email();
            var validPasswords = validate_passwords();
            return validEmail && validPasswords;
        }
    </script>
</body>
</html>
