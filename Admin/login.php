<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['admin_logged_in'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    // Close statement
    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Admin Login Form</title>
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

        /* .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: rgba(0, 0, 0, 0.5);
            width: 300px;
        } */

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
            color: #7FFFD4; /* Set color for header text */
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
            background-color: #11ce1b; /* Green background color */
            color: #000; /* Black font color */
            border: 1.5px solid white; /* White border */
            box-shadow: 0 0 0 1.5px white, 0 0 0 3px blue; /* White and blue shadow effect */
            font-size: 18px;
            margin-top: 10px;
        }

        .login-container .error {
            color: red;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Text Centering */
        .text-center {
            text-align: center;
            color: #7FFFD4; /* Apply color to text-center class */
        }

        /* Centering the logo */
        /* Logo */
        .logo {
            width: 75px;
            height: auto;
            box-shadow: 10px 7px 20px green;
            margin-bottom: 10px;
        }

        /* Input Fields */
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

    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-4">
            <img src="logo.png" alt="TrendCart Logo" class="logo">
            <h1>Admin Login</h1>          
        </div>

        <form method="POST" action="" onsubmit="return validate_form();">
            <label for="email">E-Mail *</label>
            <input type="email" class="input1" id="email" name="email" placeholder="Email" oninput="validate_email()">
            <div id="email-error" class="error"></div>
            <label for="password">Password  *</label>
            <input type="password" class="input1" id="password" name="password" placeholder="Password" oninput="validate_password()">
            <div id="password-error" class="error"></div>
            <button type="submit">Login</button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
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

        function validate_password() {
            var passwordF = document.getElementById("password");
            var passwordE = document.getElementById("password-error");
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,14}$/;

            if (passwordF.value === "") {
                passwordE.innerHTML = "Password cannot be empty";
                passwordF.classList.add("input-error");
                passwordF.classList.remove("input-success");
                return false;
            } else if (!passwordF.value.match(passwordPattern)) {
                passwordE.innerHTML = "Password must be 8-14 characters long and include at least one lowercase letter, one uppercase letter, one number, and one special character";
                passwordF.classList.add("input-error");
                passwordF.classList.remove("input-success");
                return false;
            } else {
                passwordE.innerHTML = "";
                passwordF.classList.remove("input-error");
                passwordF.classList.add("input-success");
                return true;
            }
        }

        function validate_form() {
            var validEmail = validate_email();
            var validPassword = validate_password();
            return validEmail && validPassword;
        }
    </script>
</body>
</html>
