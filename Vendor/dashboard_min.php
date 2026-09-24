<?php
include "db.php";

// Fetch vendor ID based on logged-in username
$vendorUsername = $_SESSION['username'];
$vendorQuery = "SELECT id FROM vendors WHERE username = '$vendorUsername'";
$vendorResult = $conn->query($vendorQuery);
$vendorRow = $vendorResult->fetch_assoc();
$vendorId = $vendorRow['id'];

// Fetch total products
$totalProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE vendor_id = $vendorId";
$totalProductsResult = $conn->query($totalProductsQuery);
$total_product = $totalProductsResult->fetch_assoc()['total'];

// Fetch total pending products
$pendingProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'pending' && vendor_id = '$vendorId'";
$pendingProductsResult = $conn->query($pendingProductsQuery);
$pending_products = $pendingProductsResult->fetch_assoc()['total'];

// Fetch total verified products
$verifiedProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'verified' && vendor_id = '$vendorId'";
$verifiedProductsResult = $conn->query($verifiedProductsQuery);
$verified_products = $verifiedProductsResult->fetch_assoc()['total'];

// Fetch total not verified products
$notVerifiedProductsQuery = "SELECT COUNT(*) AS total FROM product WHERE status = 'not_verified' && vendor_id = '$vendorId'";
$notVerifiedProductsResult = $conn->query($notVerifiedProductsQuery);
$not_verified_products = $notVerifiedProductsResult->fetch_assoc()['total'];

?>

<div class="row mb-3">
    <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
        <div class="card bg-dark text-white mt-3 no-border">
            <div class="card-body d-flex align-items-center fs-5">
                <a href="#" class="text-white fw-bold" id="showProductDetails">
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
            <div class="card-body d-flex align-items-center fs-5">
                <a href="profile.php" class="text-white fw-bold ">
                    <div class="me-4 total-label">Manage Profile</div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Hidden product details section -->
<div id="productDetails" style="display: none;">
    <div class="row mb-3">
        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-warning text-white mt-3 no-border">
                <div class="card-body d-flex align-items-center fs-5">
                    <a href="pending_product_list.php" class="text-white fw-bold">
                        <div class="me-4 total-label">Pending Products &nbsp;
                            <strong>
                                <?php echo htmlspecialchars($pending_products); ?>
                            </strong>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-success text-white mt-3 no-border">
                <div class="card-body d-flex align-items-center fs-5">
                    <a href="verify_product_list.php" class="text-white fw-bold">
                        <div class="me-4 total-label">Verified Products &nbsp;
                            <strong>
                                <?php echo htmlspecialchars($verified_products); ?>
                            </strong>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
            <div class="card bg-danger text-white mt-3 no-border">
                <div class="card-body d-flex align-items-center fs-5">
                    <a href="not_verify_product_list.php" class="text-white fw-bold">
                        <div class="me-4 total-label">Not Verified Products &nbsp;
                            <strong>
                                <?php echo htmlspecialchars($not_verified_products); ?>
                            </strong>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("showProductDetails").addEventListener("click", function() {
        document.getElementById("productDetails").style.display = "block";
    });

    document.getElementById("showVendorDetails").addEventListener("click", function() {
        document.getElementById("vendorDetails").style.display = "block";
    });
</script>
