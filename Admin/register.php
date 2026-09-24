<?php
session_start();
include('db.php');

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed_password);

    // Execute statement
    if ($stmt->execute()) {
        // Registration successful, redirect to login page
        header("Location: index.php");
        exit();
    } else {
        $error = "Error in registration. Please try again.";
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
    <title>Admin Registration</title>
    <style>
        body {font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f0f0f0; margin: 0;}
        .register-container {background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px;}
        .register-container h2 {margin-top: 0; color: #333;}
        .register-container input {width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px;}
        .register-container input.input-error {border-color: red;}
        .register-container input.input-success {border-color: green;}
        .register-container button {width: 100%; padding: 10px; background-color: #007BFF; border: none; border-radius: 4px; color: #fff; font-size: 16px;}
        .register-container button:hover {background-color: #0056b3;}
        .register-container .error {color: red; margin-top: 10px;}
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Admin Registration</h2>
        <form method="POST" action="" onsubmit="return validate_form();">
            <input type="email" id="email" name="email" placeholder="Email" required oninput="validate_email()">
            <div id="email-error" class="error"></div>
            <input type="password" id="password" name="password" placeholder="Password" required oninput="validate_password()">
            <div id="password-error" class="error"></div>
            <button type="submit">Register</button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>

    <script>
        function validate_email() {
            var emailF = document.getElementById("email");
            var emailE = document.getElementById("email-error");
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailF.value.match(emailPattern)) {
                emailE.innerHTML = "Please enter a valid email address";
                emailF.classList.add("input-error");
                emailF.classList.remove("input-success");
                return false;
            } else {
                emailE.innerHTML = "";
                emailF.classList.remove("input-error");
                emailF.classList.add("input-success");
                return true;
            }
        }

        function validate_password() {
            var passwordF = document.getElementById("password");
            var passwordE = document.getElementById("password-error");
            if (passwordF.value === "") {
                passwordE.innerHTML = "Enter password";
                passwordF.classList.add("input-error");
                passwordF.classList.remove("input-success");
                return false;
            } else if (passwordF.value.length < 6) {
                passwordE.innerHTML = "Password must be at least 6 characters long";
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


<!-- CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(70) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->
