<?php
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Sidebar</title>

    <script src="https://kit.fontawesome.com/7f06d056a6.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            padding: 20px;
            margin: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .dashboard-container h1 {
            margin-top: 0;
            color: #333;
        }
        .dashboard-container a {
            color: #007BFF;
            text-decoration: none;
        }
        .dashboard-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div style="position: fixed; height: 100%;">
                <div class="d-flex">
                    <button class="toggle-btn" type="button">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="#">TrendCart</a>
                    </div>
                </div>

                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="dashboard.php" class="sidebar-link">
                            <i class="fa-solid fa-house" title='Dashboard'></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="product_list.php" class="sidebar-link">
                            <i class="fa-brands fa-product-hunt" title='Dashboard'></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown"  data-bs-toggle="collapse"
                        data-bs-target="#product" aria-expanded="false" aria-controls="product"> 
                            <i class="fa-brands fa-product-hunt" title='Product'></i>
                            <span>Products</span>
                        </a>
                        <ul id="product" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="pending_product_list.php" class="sidebar-link">Pending Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="verify_product_list.php" class="sidebar-link">Verify Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="not_verify_product_list.php" class="sidebar-link">Not-Verify Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="product_list.php" class="sidebar-link">All Products</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="sidebar-item">
                        <a href="reports.php" class="sidebar-link">
                            <i class="fa-solid fa-note-sticky" title='Reports'></i>
                            <span>Reports</span>
                        </a>
                    </li> -->
                    <li class="sidebar-item">
                        <a href="profile.php" class="sidebar-link">
                            <i class="fa-solid fa-user" title='Profile'></i>
                            <span>Profile</span>
                        </a>
                    </li>
                
                    <div class="sidebar-footer">
                        <a href="javascript:void(0);" class="sidebar-link" onclick="confirmLogout()">
                            <i class="fa-solid fa-right-from-bracket" title='Logout'></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </ul>
            </div>
        </aside>

        <!-- <div class="main p-3"> -->
            <!-- <h1 class="navbar-text">
                Welcome to <?php // echo $_SESSION['username']; ?> Dashboard
            </h1> -->
            <!-- Main content of the dashboard -->
        <!-- </div> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        }
    </script>
</body>
</html>
