<?php
include "db.php";
session_start();

if(isset($_COOKIE['email_username']) && isset($_COOKIE['password'])) {
    $id = $_COOKIE['email_username'];
    $pass = $_COOKIE['password'];
} else {
    $id = "";
    $pass = "";
}  

if (isset($_POST['login'])) {
    // Sanitize input
    $email_username = mysqli_real_escape_string($conn, $_POST['email_username']);
    $password = $_POST['password'];

    // Query to find the user by username or email
    $query = "SELECT * FROM `vendors` WHERE `username` = '$email_username' OR `email` = '$email_username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);

            // if ($result_fetch['is_verified'] == 1) {
            if ($result_fetch['is_verified'] == 'Joined') {
                // Verify the password
                if (password_verify($password, $result_fetch['password'])) {
                    // Set session variables
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $result_fetch['username'];

                    // Handle 'Remember Me' functionality
                    if (isset($_POST['remember_me'])) {
                        setcookie('email_username', $_POST['email_username'], time() + (60*60*24));
                        setcookie('password', $_POST['password'], time() + (60*60*24));
                    } else {
                        // Delete cookies if 'Remember Me' is not checked
                        setcookie('email_username', '', time() - (60*60*24));
                        setcookie('password', '', time() - (60*60*24));
                    }

                    // Redirect to the desired page
                    header("location: index.php");
                    exit();
                } else {
                    echo "<script> 
                            alert('Incorrect Password');
                            window.location.href = 'index.php';
                        </script>";
                }
            } else {
                echo "<script> 
                        alert('Email Not Verified');
                        window.location.href = 'index.php';
                    </script>";
            }
        } else {
            echo "<script> 
                    alert('Email or Username Not Registered');
                    window.location.href = 'index.php';
                </script>";
        }
    } else {
        echo "<script> 
                alert('Cannot Run Query');
                window.location.href = 'index.php';
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Vendor Login Form</title>
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

        /* Style for the login link */
        .text-center {
            text-align: center;
            margin-top: 20px; /* Adjust the margin-top value as needed */
        }

        .text-center .link {
            color: #007BFF;
            text-decoration: none;
        }

        .text-center .link:hover {
            text-decoration: underline;
        }

        .forgot-password-container {
            display: flex;
            justify-content: flex-end; /* Aligns the link to the right */
            margin-top: 20px; /* Adjust the margin-top value as needed */
        }

        .forgot-password-container .link1 {
            color: #007BFF;
            text-decoration: none;
        }

        .forgot-password-container .link1:hover {
            text-decoration: underline;
        }

        p {
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="text-center mb-4">
            <img src="logo.png" alt="TrendCart Logo" class="logo">
            <h1>Vendor Login</h1>          
        </div>

        <form method="POST" action="" onsubmit="return validate_form();">
            <label for="email_username">Username or E-Mail *</label>
            <input type="text" class="input1" id="email_username" name="email_username" placeholder="Username or Email" oninput="validate_email_username()">
            <div id="email-username-error" class="error"></div>
            <label for="password">Password *</label>
            <input type="password" class="input1" id="password" name="password" placeholder="Password" oninput="validate_password()">
            <div id="password-error" class="error"></div>
            <!-- <label>
                <input type="checkbox" class="input2" name="remember_me" id="remember_me"> Remember Me
            </label> -->
            <button type="submit" name="login">Login</button>
            <div class="forgot-password-container">
                <a href="forgot_password.php" class="link1">Forgot Password?</a></p>
            </div>
            <div class="text-center">
                <p>Don't have an account? <a href="register.php" class="link">Register here</a></p>
            </div>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>

    <script>
        function validate_email_username() {
            var emailUsernameF = document.getElementById("email_username");
            var emailUsernameE = document.getElementById("email-username-error");
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

            if (emailUsernameF.value === "") {
                emailUsernameE.innerHTML = "Username or E-Mail cannot be empty";
                emailUsernameF.classList.add("input-error");
                emailUsernameF.classList.remove("input-success");
                return false;
            } else if (!emailUsernameF.value.match(emailPattern) && emailUsernameF.value.includes('@')) {
                emailUsernameE.innerHTML = "Please enter a valid email address";
                emailUsernameF.classList.add("input-error");
                emailUsernameF.classList.remove("input-success");
                return false;
            } else {
                emailUsernameE.innerHTML = "";
                emailUsernameF.classList.remove("input-error");
                emailUsernameF.classList.add("input-success");
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
            var validEmailUsername = validate_email_username();
            var validPassword = validate_password();
            return validEmailUsername && validPassword;
        }
    </script>
</body>
</html>
