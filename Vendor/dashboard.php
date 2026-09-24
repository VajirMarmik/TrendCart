<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit();
}
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Vendor Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="wrapper">
        <?php include "vendor_sidebar.php"; ?>

        <div class="main p-3">
            
            <div class="text-center">
                <h1 style="font-size: 30px;">Welcome to <?php echo htmlspecialchars($_SESSION['username']); ?> Dashboard</h1>
            </div>

            <div class="container mt-3">
                <?php include "dashboard_min.php"; ?>
            </div>

            <?php
// Fetch category names and IDs related to the logged-in vendor
$categoriesQuery = "
    SELECT c.id, c.name
    FROM categories c
    WHERE EXISTS (
        SELECT 1
        FROM product p
        WHERE p.category_id = c.id AND p.vendor_id = $vendorId
    )";
$categoriesResult = $conn->query($categoriesQuery);

$categoryCounts = [];
$totalCategoryProducts = 0;

// Count products for each category
while ($category = $categoriesResult->fetch_assoc()) {
    $categoryId = $category['id'];
    $categoryName = $category['name'];

    // Get count of products in the current category
    $productCountQuery = "SELECT COUNT(*) AS count FROM product WHERE category_id = $categoryId AND vendor_id = $vendorId";
    $productCountResult = $conn->query($productCountQuery);
    $productCount = $productCountResult->fetch_assoc()['count'];

    // Store the count and calculate the total products
    $categoryCounts[$categoryName] = $productCount;
    $totalCategoryProducts += $productCount;
}

// Calculate percentages for categories
$categoryPercentages = [];
foreach ($categoryCounts as $category => $count) {
    $categoryPercentages[$category] = $totalCategoryProducts > 0 ? ($count / $totalCategoryProducts) * 100 : 0;
}

// Fetch brand names and IDs related to the logged-in vendor
$brandsQuery = "
    SELECT b.id, b.name
    FROM brands b
    WHERE EXISTS (
        SELECT 1
        FROM product p
        WHERE p.brand_id = b.id AND p.vendor_id = $vendorId
    )";
$brandsResult = $conn->query($brandsQuery);

$brandCounts = [];
$totalBrandProducts = 0;

// Count products for each brand
while ($brand = $brandsResult->fetch_assoc()) {
    $brandId = $brand['id'];
    $brandName = $brand['name'];

    // Get count of products in the current brand
    $productCountQuery = "SELECT COUNT(*) AS count FROM product WHERE brand_id = $brandId AND vendor_id = $vendorId";
    $productCountResult = $conn->query($productCountQuery);
    $productCount = $productCountResult->fetch_assoc()['count'];

    // Store the count and calculate the total products
    $brandCounts[$brandName] = $productCount;
    $totalBrandProducts += $productCount;
}

// Calculate percentages for brands
$brandPercentages = [];
foreach ($brandCounts as $brand => $count) {
    $brandPercentages[$brand] = $totalBrandProducts > 0 ? ($count / $totalBrandProducts) * 100 : 0;
}
?>

<div class="container mb-5">
    <div class="row">
        <!-- First Chart Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5><b>Category Distribution</b></h5>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="max-width: 100%; height: auto;"></canvas>
                </div>
            </div>
        </div>

        <!-- Second Chart Card -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5><b>Brand Distribution</b></h5>
                </div>
                <div class="card-body">
                    <canvas id="brandChart" style="max-width: 100%; height: auto;"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Filter category data for non-zero values
    const rawCategoryLabels = <?php echo json_encode(array_keys($categoryPercentages)); ?>;
    const rawCategoryData = <?php echo json_encode(array_values($categoryPercentages)); ?>;

    const filteredCategoryData = rawCategoryData
        .map((value, index) => ({ label: rawCategoryLabels[index], value }))
        .filter(item => item.value > 0);

    const categoryLabels = filteredCategoryData.map(item => item.label);
    const categoryData = filteredCategoryData.map(item => item.value);
    const categoryColors = categoryLabels.map(() => `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`);

    new Chart(document.getElementById('categoryChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: categoryColors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'left' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return categoryLabels[tooltipItem.dataIndex] + ': ' + categoryData[tooltipItem.dataIndex].toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });

    // Filter brand data for non-zero values
    const rawBrandLabels = <?php echo json_encode(array_keys($brandPercentages)); ?>;
    const rawBrandData = <?php echo json_encode(array_values($brandPercentages)); ?>;

    const filteredBrandData = rawBrandData
        .map((value, index) => ({ label: rawBrandLabels[index], value }))
        .filter(item => item.value > 0);

    const brandLabels = filteredBrandData.map(item => item.label);
    const brandData = filteredBrandData.map(item => item.value);
    const brandColors = brandLabels.map(() => `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`);

    new Chart(document.getElementById('brandChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: brandLabels,
            datasets: [{
                data: brandData,
                backgroundColor: brandColors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'left' },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return brandLabels[tooltipItem.dataIndex] + ': ' + brandData[tooltipItem.dataIndex].toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });
</script>

        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
