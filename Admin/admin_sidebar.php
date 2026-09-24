<?php

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <script src="https://kit.fontawesome.com/7f06d056a6.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <a href="category.php" class="sidebar-link">
                            <i class="fa-solid fa-c" title='Categories'></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="brand.php" class="sidebar-link">
                            <i class="fa-solid fa-b" title='Brands'></i>
                            <span>Brand</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="product_view.php" class="sidebar-link">
                            <i class="fa-brands fa-product-hunt" title='Products'></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a href="vendor.php" class="sidebar-link">
                            <i class="fa-solid fa-user" title='Vendors'></i>
                            <span>Vendors</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="customer.php" class="sidebar-link">
                            <i class="fa-solid fa-user" title='Customers'></i>
                            <span>Customers</span>
                        </a>
                    </li> -->
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown"  data-bs-toggle="collapse"
                        data-bs-target="#product" aria-expanded="false" aria-controls="product">
                            <i class="fa-solid fa-user" title='Users'></i>
                            <span>Users</span>
                        </a>
                        <ul id="product" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="vendor.php" class="sidebar-link">Vendors</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="customer.php" class="sidebar-link">Customers</a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown"  data-bs-toggle="collapse"
                        data-bs-target="#product" aria-expanded="false" aria-controls="product">
                            <i class="fa-solid fa-p" title='Product Verification'></i>
                            <span>Products</span>
                        </a>
                        <ul id="product" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="pending_product_view.php" class="sidebar-link">Pending Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="verify_product_view.php" class="sidebar-link">Verify Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="not_verify_product_view.php" class="sidebar-link">Not-Verify Products</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="product_view.php" class="sidebar-link">All Products</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown"  data-bs-toggle="collapse"
                        data-bs-target="#vendor" aria-expanded="false" aria-controls="product">
                            <i class="fa-solid fa-v" title='Vendor Verification'></i>
                            <span>Vendors</span>
                        </a>
                        <ul id="product" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="email_send_vendor.php" class="sidebar-link">Verified Vendor</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="email_not_send_vendor.php" class="sidebar-link">Vendor Verification Pending</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="email_verify_vendor.php" class="sidebar-link">Verify Joined</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="email_not_verify_vendor.php" class="sidebar-link">Vendor Not Joined</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="vendor.php" class="sidebar-link">All Vendorss</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="sidebar-item">
                        <a href="customer.php" class="sidebar-link">
                            <i class="fa-solid fa-user" title='Customer'></i>
                            <span>Customer</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="vendor.php" class="sidebar-link">
                            <i class="fa-solid fa-v" title='Vendor'></i>
                            <span>Vendor</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="reports.php" class="sidebar-link">
                            <i class="fa-solid fa-note-sticky" title='Reports'></i>
                            <span>Reports</span>
                        </a>
                    </li> -->
                    <!-- <li class="sidebar-item">
                        <a href="subscription_Plan.php" class="sidebar-link">
                            <i class="fa-solid fa-s" title='Subscription Plan'></i>
                            <span>Subscription Plan</span>
                        </a>
                    </li> -->
                    <li class="sidebar-item">
                        <a href="view_feedback.php" class="sidebar-link">
                            <i class="fa-solid fa-v" title='View Feedback'></i>
                            <span>View Feedback</span>
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
        <!-- <div class="main p-3">
            <div class="text-center">
                <h1>
                    Welcome to Admin Dashboard
                </h1>
            </div>
        </div> -->
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
