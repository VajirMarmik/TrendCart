<?php
include "db.php";

// Fetch total categories
$totalCategoriesQuery = "SELECT COUNT(*) AS total FROM categories";
$totalCategoriesResult = $conn->query($totalCategoriesQuery);
$total_categories = $totalCategoriesResult->fetch_assoc()['total'];

// Fetch total brands
$totalBrandsQuery = "SELECT COUNT(*) AS total FROM brands";
$totalBrandsResult = $conn->query($totalBrandsQuery);
$total_brands = $totalBrandsResult->fetch_assoc()['total'];

// Fetch total products
$totalProductsQuery = "SELECT COUNT(*) AS total FROM product";
$totalProductsResult = $conn->query($totalProductsQuery);
$total_product = $totalProductsResult->fetch_assoc()['total'];

// Fetch total pending products
$pendingProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'pending'";
$pendingProductsResult = $conn->query($pendingProductsQuery);
$pending_products = $pendingProductsResult->fetch_assoc()['total'];

// Fetch total verified products
$verifiedProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'verified'";
$verifiedProductsResult = $conn->query($verifiedProductsQuery);
$verified_products = $verifiedProductsResult->fetch_assoc()['total'];

// Fetch total not verified products
$notVerifiedProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'not_verified'";
$notVerifiedProductsResult = $conn->query($notVerifiedProductsQuery);
$not_verified_products = $notVerifiedProductsResult->fetch_assoc()['total'];

// Fetch total customers
$totalCustomersQuery = "SELECT COUNT(*) AS total FROM customer"; // Change 'vendors' to 'customers'
$totalCustomersResult = $conn->query($totalCustomersQuery);
$total_customers = $totalCustomersResult->fetch_assoc()['total']; // Change variable name to $total_customers

// Fetch total vendors
$totalVendorsQuery = "SELECT COUNT(*) AS total FROM vendors";
$totalVendorsResult = $conn->query($totalVendorsQuery);
$total_vendors = $totalVendorsResult->fetch_assoc()['total'];

// Fetch verified vendors
$verifiedVendorsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE verification_status = 'Verified'";
$verifiedVendorsResult = $conn->query($verifiedVendorsQuery);
$verified_vendors = $verifiedVendorsResult->fetch_assoc()['total'];

// Fetch verification pending vendors
$pendingVendorsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE verification_status = 'Not Verified'";
$pendingVendorsResult = $conn->query($pendingVendorsQuery);
$pending_vendors = $pendingVendorsResult->fetch_assoc()['total'];

// Fetch joined vendors
$joinedVendorsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE is_verified = 'Joined'";
$joinedVendorsResult = $conn->query($joinedVendorsQuery);
$joined_vendors = $joinedVendorsResult->fetch_assoc()['total'];

// Fetch not joined vendors
$notJoinedVendorsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE is_verified = 'Not Joined'";
$notJoinedVendorsResult = $conn->query($notJoinedVendorsQuery);
$not_joined_vendors = $notJoinedVendorsResult->fetch_assoc()['total'];

// Close the database connection
$conn->close();
?>

<div class="row mb-3">

    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
        <div class="card bg-primary text-white mt-3 no-border">
            <a href="category.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                <div class="me-4 total-label">Total Categories</div>
                <strong>
                    <?php echo htmlspecialchars($total_categories); ?>
                </strong>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
        <div class="card bg-primary text-white mt-3 no-border">
            <a href="brand.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                <div class="me-4 total-label">Total Brands</div>
                <strong>
                    <?php echo htmlspecialchars($total_brands); ?>
                </strong>
            </a>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
        <div class="card bg-dark text-white mt-3 no-border">
            <div class="card-body d-flex align-items-center fs-5" id="showProductDetails">
                <a href="#" class="text-white" id="showProductDetails">
                    <div class="me-4 total-label">Total Products &nbsp;
                        <strong>
                            <?php echo htmlspecialchars($total_product); ?>
                        </strong>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
        <div class="card bg-dark text-white mt-3 no-border">
            <a href="#" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer" id="showUsers">
                <div class="me-4 total-label">Total Users</div>
            </a>
        </div>
    </div>

</div>

<!-- Hidden product details section -->
<div id="productDetails" style="display: none;">
    <div class="row mb-3">
        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-warning text-white mt-3 no-border">
                <a href="pending_product_view.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Pending Products</div>
                    <strong>
                        <?php echo htmlspecialchars($pending_products); ?>
                    </strong>
                </a>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-success text-white mt-3 no-border">
                <a href="verify_product_view.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Verified Products</div>
                    <strong>
                        <?php echo htmlspecialchars($verified_products); ?>
                    </strong>
                </a>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-danger text-white mt-3 no-border">
                <a href="not_verify_product_view.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Not Verified Products</div>
                    <strong>
                        <?php echo htmlspecialchars($not_verified_products); ?>
                    </strong>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Hidden user details section -->
<div id="users" style="display: none;">
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-dark text-white mt-3 no-border">
                <!-- <a href="vendor.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer" id="showVendorDetails"> -->
                <a href="#" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer" id="showVendorDetails">
                    <div class="me-4 total-label">Total Vendors</div>
                    <strong>
                        <?php echo htmlspecialchars($total_vendors); ?>
                    </strong>
                </a>
            </div>
        </div>


        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-warning text-white mt-3 no-border">
                <a href="customer.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Total Customers</div>
                    <strong>
                        <?php echo htmlspecialchars($total_customers); ?>
                    </strong>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Hidden vendor details section -->
<div id="vendorDetails" style="display: none;">
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-success text-white mt-3 no-border">
                <a href="email_send_vendor.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Verified Vendors</div>
                    <strong>
                        <?php echo htmlspecialchars($verified_vendors); ?>
                    </strong>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-warning text-white mt-3 no-border">
                <a href="email_not_send_vendor.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Verification Pending Vendors</div>
                    <strong>
                        <?php echo htmlspecialchars($pending_vendors); ?>
                    </strong>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-info text-white mt-3 no-border">
                <a href="email_verify_vendor.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Joined Vendors</div>
                    <strong>
                        <?php echo htmlspecialchars($joined_vendors); ?>
                    </strong>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
            <div class="card bg-secondary text-white mt-3 no-border">
                <a href="email_not_verify_vendor.php" class="card-body d-flex align-items-center fs-5 text-white cursor-pointer">
                    <div class="me-4 total-label">Not Joined Vendors</div>
                    <strong>
                        <?php echo htmlspecialchars($not_joined_vendors); ?>
                    </strong>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("showProductDetails").addEventListener("click", function() {
        // Show product details
        document.getElementById("productDetails").style.display = "block";
        // Hide other elements
        document.getElementById("users").style.display = "none";
        document.getElementById("vendorDetails").style.display = "none";
    });

    document.getElementById("showUsers").addEventListener("click", function() {
        // Show user details
        document.getElementById("users").style.display = "block";
        // Hide other elements
        document.getElementById("productDetails").style.display = "none";
        document.getElementById("vendorDetails").style.display = "none";
    });

    document.getElementById("showVendorDetails").addEventListener("click", function() {
        // Show vendor details
        document.getElementById("vendorDetails").style.display = "block";
        // Hide other elements
        document.getElementById("productDetails").style.display = "none";
        document.getElementById("users").style.display = "none";
    });
</script>