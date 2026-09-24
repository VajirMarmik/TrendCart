<?php 
include "db.php"; 
session_start();

// if(isset($_COOKIE['email_username']) && isset($_COOKIE['password'])) {
//   $id = $_COOKIE['email_username'];
//   $pass = $_COOKIE['password'];
// } else {
//   $id = "";
//   $pass = "";
// }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TrendCart - Vendor Register & Login</title>
  <link rel="stylesheet" href="style1.css">
  <script src="app.js" defer></script>
</head>
<body>
  
<header>
    <img src="logo.png" alt="TrendCart Logo" class="logo">
    <h1>Vendor Registration & Login Process</h1>
    <?php
      if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {         
        header('Location: dashboard.php');
        exit();
      } else {
        echo "<div class='sign-in-up'>
                  <button type='button' class='btn1' onclick=\"window.location.href='login.php'\">LOGIN</button>
                  <button type='button' class='btn1' onclick=\"window.location.href='register.php'\">REGISTER</button>
                </div>";
      }
    ?>
  </header>
</body>
</html>

