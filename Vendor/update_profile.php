<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Fetch user profile data from the database
include "db.php";

$username = $_SESSION['username'];

$query = "SELECT * FROM `vendors` WHERE `username` = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    // $pancardNumber = mysqli_real_escape_string($conn, $_POST['pancard_number']);
    $upi_id = mysqli_real_escape_string($conn, $_POST['upi_id']);

    // Handle file uploads
    $photo = $user['photo'];
    // $pancardFront = $user['pancard_front'];
    // $pancardBack = $user['pancard_back'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = '../uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }
    // if (!empty($_FILES['pancard_front']['name'])) {
    //     $pancardFront = '../uploads/' . basename($_FILES['pancard_front']['name']);
    //     move_uploaded_file($_FILES['pancard_front']['tmp_name'], $pancardFront);
    // }
    // if (!empty($_FILES['pancard_back']['name'])) {
    //     $pancardBack = '../uploads/' . basename($_FILES['pancard_back']['name']);
    //     move_uploaded_file($_FILES['pancard_back']['tmp_name'], $pancardBack);
    // }

    // Update the database
    $updateQuery = "UPDATE `vendors` SET 
        `full_name` = '$fullName', 
        `email` = '$email', 
        `phone` = '$phone', 
        `photo` = '$photo',
        `upi_id` = '$upi_id'
        WHERE `username` = '$username'";
    if (mysqli_query($conn, $updateQuery)) {
        // Redirect to profile.php after successful update
        header('Location: profile.php');
        exit();
    } else {
        $message = "Error updating profile: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - <?php echo htmlspecialchars($user['username']); ?> Update Profile</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Arial', sans-serif;
        }
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
        .value input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }
        .value {
            color: #222222;
            font-size: 1.1rem;
            text-align: center;
        }
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
        .photo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .profile-photo {
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
        }

        .grid-item.photo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .photo-input-container input[type="file"] {
            margin-top: 20px;
            margin-left: 95px;
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

        <div class="container mt-3">
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fs-4">Update Profile</h1>
                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </div>
                <div class="grid-container">
                    <div class="grid-item photo">
                        <div class="label">Profile Photo</div><br>
                        <div class="photo-container">
                            <div class="photo-input-container">
                                <img class="profile-photo" src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile Photo">
                                <input type="file" name="photo" class="file-input">
                            </div>
                        </div><br>
                    </div>

                    <div class="grid-item full-name">
                        <div class="label">Full Name</div>
                        <div class="value"><input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required></div>
                    </div>
                    <div class="grid-item username">
                        <div class="label">User Name</div>
                        <div class="value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="grid-item phone-number">
                        <div class="label">Phone Number</div>
                        <div class="value"><input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required></div>
                    </div>
                    <div class="grid-item email">
                        <div class="label">E-Mail</div>
                        <div class="value"><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></div>
                    </div>
                    <div class="grid-item pancard-number">
                        <div class="label">PAN Card Number</div>
                        <div class="value"><?php echo htmlspecialchars($user['pancard_number']); ?></div>
                    </div>
                    <div class="grid-item upi_id">
                        <div class="label">UPI ID</div>
                        <div class="value"><input type="text" name="upi_id" value="<?php echo htmlspecialchars($user['upi_id']); ?>" required></div>
                    </div>
                    <div class="grid-item plan">
                        <div class="label">Subscription Plan</div>
                        <div class="value"><input type="text" name="plan" value="<?php echo htmlspecialchars($user['make_plan']); ?>" required></div>
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
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to save the changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, save it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show success message
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        // Submit the form after success message
                        form.submit();
                    });
                }
            });
        });
    });
</script>

</body>
</html>
