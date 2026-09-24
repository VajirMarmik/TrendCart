<?php
include 'config.php';

$username = $_SESSION['username'];

$query = "SELECT * FROM `vendors` WHERE `username` = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - <?php echo htmlspecialchars($user['username']); ?> Profile</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body background and typography */
        body {
            background-color: #f4f7f6;
            font-family: 'Arial', sans-serif;
        }

        /* Main container styling */
        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 2rem auto;
        }

        .main h1 {
            color: #333333;
        }

        /* Styling for grid items */
        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: repeat(7, auto);
            gap: 1rem;
        }

        @media(min-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr 2fr;
                grid-template-rows: repeat(5, auto);
            }

            .photo {
                grid-row: 1 / 8;
                grid-column: 1 / 2;
            }
        }

        .grid-item {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 1rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .photo img, .pancard-front img, .pancard-back img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .photo img:hover, .pancard-front img:hover, .pancard-back img:hover {
            transform: scale(1.05);
        }

        .label {
            font-weight: bold;
            color: #555555;
        }

        .value {
            color: #222222;
            font-size: 1.1rem;
        }

        /* Update profile button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border-radius: 25px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 15px rgba(0, 91, 187, 0.4);
        }

        /* Card shadow for each section */
        .grid-item {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .grid-item.photo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .photo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%; /* Adjust height as needed */
        }

        .profile-photo {
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%; /* If you want a circular photo */
        }

    </style>
</head>
<body>
<div class="wrapper">
    <?php include "vendor_sidebar.php"; ?>

    <div class="main p-3">
        <div class="text-center mb-4">
            <h1 class="fs-3">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        </div>

        <div class="container">
            <?php include "dashboard_min.php"; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="fs-4">Profile Details</h1>
                <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
            </div>

            <div class="grid-container">
                <div class="grid-item photo">
                    <div class="label">Profile Photo</div><br>
                    <div class="photo-container">
                        <img class="profile-photo" src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile Photo">
                    </div>
                </div>

                <div class="grid-item full-name">
                    <div class="label">Full Name</div>
                        <div class="value"><?php echo htmlspecialchars($user['full_name']); ?></div>
                    </div>
                    <div class="grid-item username">
                        <div class="label">User Name</div>
                        <div class="value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="grid-item phone-number">
                        <div class="label">Phone Number</div>
                        <div class="value"><?php echo htmlspecialchars($user['phone']); ?></div>
                    </div>
                    <div class="grid-item email">
                        <div class="label">E-Mail</div>
                        <div class="value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    <div class="grid-item pancard-number">
                        <div class="label">PAN Card Number</div>
                        <div class="value"><?php echo htmlspecialchars($user['pancard_number']); ?></div>
                    </div>
                    <div class="grid-item upi_id">
                        <div class="label">UPI ID</div>
                        <div class="value"><?php echo htmlspecialchars($user['upi_id']); ?></div>
                    </div>
                    <div class="grid-item plan">
                        <div class="label">Subscription Plan</div>
                        <div class="value"><?php echo htmlspecialchars($user['make_plan']); ?></div>
                    </div>
                    <div class="grid-item pancard-front">
                        <div class="label">PanCard Front</div><br>
                        <img src="<?php echo htmlspecialchars($user['pancard_front']); ?>" alt="PAN Card Front">
                    </div>
                    <div class="grid-item pancard-back">
                        <div class="label">PanCard Back</div><br>
                        <img src="<?php echo htmlspecialchars($user['pancard_back']); ?>" alt="PAN Card Back">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
