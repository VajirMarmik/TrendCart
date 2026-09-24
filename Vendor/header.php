<?php
include "db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve user name if logged in
$userName = "";
if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
    $result = mysqli_query($conn, "SELECT full_name FROM customer WHERE email='$email'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userName = $row['full_name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>TrendCart - Vendor Homepage</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your custom CSS -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Default Light Theme */
        body {
            background-color: #f8f9fa; 
            color: #212529; 
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Dark Theme */
        body.dark-theme {
            background-color: #343a40;
            color: #ffffff;
        }

        /* Navbar Styles */
        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-brand img {
            width: 50px;
            height: auto;
            box-shadow: 10px 7px 20px green;
            margin-bottom: 10px;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.1);
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #ffffff;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        
        .theme-toggle, .user-box, .cart-box {
            margin-left: 15px;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
        }

        .footer a {
            color: #ffffff;
        }

        .footer a:hover {
            color: #00d1b2;
        }

        @media (max-width: 767px) {
            .navbar-collapse {
                background: #343a40;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div class="container">
        <a class="navbar-brand text-light d-flex align-items-center mx-auto" href="#">
            <img src="../uploads/logo.png" alt="Logo" class="navbar-brand-img">
            <span class="text-success font-weight-bold ml-3">TRENDCART</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center ml-2" id="navbarNav">
            <ul class="navbar-nav mt-0">
                <li class="nav-item"><a class="nav-link text-light" href="index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="subscription.php">SUBSCRIPTION</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="about.php">ABOUT US</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="faq.php">FAQ</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="contact.php">CONTACT US</a></li>
            </ul>
            <div class="ml-auto d-flex align-items-center">
                <div class="theme-toggle ml-3">
                    <i class='bx bx-moon text-light' id="themeIcon" style="cursor: pointer;"></i>
                </div>

                <div class="user-box ml-3 d-flex align-items-center">
                    <?php if ($userName): ?>
                        <select onchange="handleUserAction(this.value)" class="form-control" style="border: none; background: transparent; color: #fff; font-size: 1.2em; cursor: pointer; margin-left: 10px;">
                            <option value="" disabled selected><?php echo htmlspecialchars($userName); ?></option>
                            <!-- <option value="profile">Profile</option> -->
                            <option value="logout"><a href="logout.php">Logout</a></option>
                        </select>
                    <?php else: ?>
                        <a href="login.php" data-toggle="modal" data-target="#authModal">
                            <i class='bx bx-user text-light' style="font-size: 1.5em;"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</nav>


<!-- <script>
    function handleUserAction(value) {
        if (value === "profile") {
            window.location.href = "profile.php"; // Redirect to profile page
        } else if (value === "logout") {
            window.location.href = "logout.php"; // Redirect to logout page
        }
    }
</script> -->



<!-- <div class="user-box ml-3">
    <a href="login.php" data-toggle="modal" data-target="#authModal"><i class='bx bx-user text-light' style="font-size: 1.5em;"></i></a>
</div> -->

                <!-- <div class="user-box ml-3">
                <?php // if ($userName): ?>
                        <span class="text-light" style="font-size: 1.2em;"><?php // echo htmlspecialchars($userName); ?></span>
                    <?php // else: ?>
                        <a href="login.php" data-toggle="modal" data-target="#authModal">
                            <i class='bx bx-user text-light' style="font-size: 1.5em;"></i>
                        </a>
                    <?php // endif; ?>
                </div>                 -->

                                <!-- <div class="user-box ml-3">
                                <?php // if ($userName): ?>
                        <select onchange="handleUserAction(this.value)" class="form-control" style="border: none; background: transparent; color: #fff; font-size: 1.2em; cursor: pointer;">
                            <option value="" disabled selected><?php // echo htmlspecialchars($userName); ?></option>
                            <option value="profile">Profile</option>
                            <option value="logout">Logout</option>
                        </select>
                    <?php // else: ?>
                        <a href="login.php" data-toggle="modal" data-target="#authModal">
                            <i class='bx bx-user text-light' style="font-size: 1.5em;"></i>
                        </a>
                    <?php // endif; ?>
                </div> -->
