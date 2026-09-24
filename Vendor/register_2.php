<?php

include "db.php";
session_start();

// if(isset($_COOKIE['email_username']) && isset($_COOKIE['password'])) {
//     $id = $_COOKIE['email_username'];
//     $pass = $_COOKIE['password'];
// } else {
//     $id = "";
//     $pass = "";
// }  

// for Registration
if (isset($_POST['register'])) {
    // Validate password and confirm password
    if ($_POST['password'] !== $_POST['confirm_password']) {
        echo "<script> 
                alert('Passwords do not match');
                window.location.href = 'index.php';
            </script>";
        exit();
    }

    $user_exist_query = "SELECT * FROM `vendors` WHERE `username` = '$_POST[username]' OR `email` = '$_POST[email]'";
    $result = mysqli_query($conn, $user_exist_query);

    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['username'] == $_POST['username']) {
                echo "<script> 
                            alert('$result_fetch[username] - Username already taken');
                            window.location.href = 'index.php';
                        </script>";                
            } else {
                echo "<script> 
                            alert('$result_fetch[email] - E-mail already taken');
                            window.location.href = 'index.php';
                        </script>";       
            }
        } else {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $v_code = bin2hex(random_bytes(16));

            $photo = $_FILES['photo']['name'];
            $pancard_front = $_FILES['panfront']['name'];
            $pancard_back = $_FILES['panback']['name'];
            $target_dir = "../uploads/";

            // Check if the uploads directory exists, if not create it
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $photo_file = $target_dir . basename($photo);
            $pancard_front_file = $target_dir . basename($pancard_front);
            $pancard_back_file = $target_dir . basename($pancard_back);

            // Upload files
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_file);
            move_uploaded_file($_FILES['panfront']['tmp_name'], $pancard_front_file);
            move_uploaded_file($_FILES['panback']['tmp_name'], $pancard_back_file);

            $query = "INSERT INTO `vendors`(`full_name`, `username`, `photo`, `phone`, `email`, `pancard_number`, `pancard_front`, `pancard_back`, `password`, `verification_code`, `is_verified`, upi_id) 
            VALUES ('$_POST[fname] $_POST[lusername]', '$_POST[username]', '$photo_file', '$_POST[phone]', '$_POST[email]', '$_POST[pancard]', '$pancard_front_file', '$pancard_back_file', '$password', '$v_code', 'Not Joined', '$_POST[upi_id]')";

            if (mysqli_query($conn, $query)) {
                echo "<script> 
                        alert('Registration Successful');
                        window.location.href = 'index.php';
                    </script>";
            } else {
                echo "<script> 
                            alert('Server Down');
                            window.location.href = 'index.php';
                        </script>";                
            }
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
    <title>TrendCart - Vendor Registration Form</title>
    <link rel="stylesheet" href="style2.css">
    <style>
        .text-center {
            text-align: center;
            margin-top: 20px;
        }

        .text-center .link {
            color: #007BFF;
            text-decoration: none;
        }

        .text-center .link:hover {
            text-decoration: underline;
        }

        p {
            color: white;
        }

        .error {
            color: red;
            font-size: 0.9em;
            display: none;
        }

        .input-valid {
            border-color: green;
        }

        .input-invalid {
            border-color: red;
        }
    </style>
    <script src="app.js" defer></script>
</head>
<body>
    <form action="register.php" method="POST" enctype="multipart/form-data" class="form" onsubmit="return validateForm()">
        <div class="text-center mb-4">
            <img src="logo.png" alt="TrendCart Logo" class="logo">
            <h1>Vendor Register Form</h1>
        </div>
        
        <!-- Progressbar -->
        <div class="progressbar">
            <div class="progress" id="progress"></div>
            <div class="progress-step active" data-title="Personal Info"></div>
            <div class="progress-step" data-title="Contact Info"></div>
            <div class="progress-step" data-title="Identity Proof"></div>
            <div class="progress-step" data-title="Bank Account Detail"></div>
            <div class="progress-step" data-title="Password"></div>
        </div>

        <!-- Step 1 -->
        <div class="form-step active">
            <div class="input-group">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" placeholder="Enter your first name" required onkeyup="validateName()">
                <span class="error" id="fname-error">Invalid name format</span>
            </div>
            <div class="input-group">
                <label for="username">User Name</label>
                <input type="text" name="username" id="username" placeholder="Enter your Username" required onkeyup="validateUsername()">
                <span class="error" id="username-error">Invalid username</span>
            </div>
            <div class="input-group">
                <label for="photo">Photo Upload</label>
                <input type="file" name="photo" id="photo" accept="image/*" required>
            </div>
            <div>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="form-step">
            <div class="input-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" placeholder="Enter your phone number"  onkeyup="validatePhone()">
                <span class="error" id="phone-error">Invalid phone number</span>
            </div>
            <div class="input-group">
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email" placeholder="Enter your email address"  onkeyup="validateEmail()">
                <span class="error" id="email-error">Invalid email address</span>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-previous">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="form-step">
            <div class="input-group">
                <label for="pancard">PAN Card Number</label>
                <input type="text" name="pancard" id="pancard" placeholder="Enter your PAN card number"  onkeyup="validatePanCard()">
                <span class="error" id="pancard-error">Invalid PAN card number</span>
            </div>
            <div class="input-group">
                <label for="panfront">PAN Card Front Photo</label>
                <input type="file" name="panfront" id="panfront" accept="image/*">
            </div>
            <div class="input-group">
                <label for="panback">PAN Card Back Photo</label>
                <input type="file" name="panback" id="panback" accept="image/*">
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-previous">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="form-step">
            <div class="input-group">
                <label for="upi_id">UPI ID</label>
                <input type="text" name="upi_id" id="upi_id" placeholder="Enter UPI ID"  onkeyup="validateUpi()">
                <span class="error" id="upi-error">Invalid UPI ID format</span>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-previous">Previous</a>
                <a href="#" class="btn btn-next">Next</a>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="form-step">
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required onkeyup="validatePassword()">
                <span class="error" id="password-error">Password must be at least 6 characters long</span>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" required onkeyup="validateConfirmPassword()">
                <span class="error" id="confirm-password-error">Passwords do not match</span>
            </div>
            <div class="btns-group">
                <a href="#" class="btn btn-previous">Previous</a>
                <input type="submit" name="register" value="Submit" class="btn">
            </div><br>
        </div>
        <div class="text-center mt-4">
            <p>Already have an account? <a href="login.php" class="link">Login here</a></p>
        </div>
    </form>

    <script>
        function validateName() {
            const nameField = document.getElementById('fname');
            const error = document.getElementById('fname-error');
            if (!nameField.value.match(/^[A-Za-z\s]+$/)) {
                error.style.display = 'block';
                nameField.classList.add('input-invalid');
                nameField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                nameField.classList.add('input-valid');
                nameField.classList.remove('input-invalid');
            }
        }

        function validateUsername() {
            const usernameField = document.getElementById('username');
            const error = document.getElementById('username-error');
            if (usernameField.value.length < 3) {
                error.style.display = 'block';
                usernameField.classList.add('input-invalid');
                usernameField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                usernameField.classList.add('input-valid');
                usernameField.classList.remove('input-invalid');
            }
        }

        function validatePhone() {
            const phoneField = document.getElementById('phone');
            const error = document.getElementById('phone-error');
            if (!phoneField.value.match(/^[0-9]{10}$/)) {
                error.style.display = 'block';
                phoneField.classList.add('input-invalid');
                phoneField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                phoneField.classList.add('input-valid');
                phoneField.classList.remove('input-invalid');
            }
        }

        function validateEmail() {
            const emailField = document.getElementById('email');
            const error = document.getElementById('email-error');
            if (!emailField.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                error.style.display = 'block';
                emailField.classList.add('input-invalid');
                emailField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                emailField.classList.add('input-valid');
                emailField.classList.remove('input-invalid');
            }
        }

        function validatePanCard() {
            const pancardField = document.getElementById('pancard');
            const error = document.getElementById('pancard-error');
            if (!pancardField.value.match(/^[A-Z]{5}[0-9]{4}[A-Z]$/)) {
                error.style.display = 'block';
                pancardField.classList.add('input-invalid');
                pancardField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                pancardField.classList.add('input-valid');
                pancardField.classList.remove('input-invalid');
            }
        }

        function validateUpi() {
            const upiField = document.getElementById('upi');
            const error = document.getElementById('upi-error');
            if (!upiField.value.match(/^[a-zA-Z0-9.\-_]{2,256}@[a-zA-Z]{3,20}$/)) {
                error.style.display = 'block';
                upiField.classList.add('input-invalid');
                upiField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                upiField.classList.add('input-valid');
                upiField.classList.remove('input-invalid');
            }
        }

        function validatePassword() {
            const passwordField = document.getElementById('password');
            const error = document.getElementById('password-error');
            if (passwordField.value.length < 6) {
                error.style.display = 'block';
                passwordField.classList.add('input-invalid');
                passwordField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                passwordField.classList.add('input-valid');
                passwordField.classList.remove('input-invalid');
            }
        }

        function validateConfirmPassword() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirm_password');
            const error = document.getElementById('confirm-password-error');
            if (confirmPasswordField.value !== passwordField.value) {
                error.style.display = 'block';
                confirmPasswordField.classList.add('input-invalid');
                confirmPasswordField.classList.remove('input-valid');
            } else {
                error.style.display = 'none';
                confirmPasswordField.classList.add('input-valid');
                confirmPasswordField.classList.remove('input-invalid');
            }
        }

        function validateForm() {
            validateName();
            validateUsername();
            validatePhone();
            validateEmail();
            validatePanCard();
            validateUpi();
            validatePassword();
            validateConfirmPassword();
            
            const invalidFields = document.querySelectorAll('.input-invalid');
            return invalidFields.length === 0;
        }
    </script>
</body>
</html>