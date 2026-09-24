<?php
include "db.php";
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Set timezone
date_default_timezone_set("Asia/Kolkata");

// Get dates from the form input or set defaults
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($startDate && !$endDate) {
    $endDate = date('Y-m-d'); // Set endDate to today's date if not provided
}

// Pagination logic
$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $recordsPerPage;

// Get total records for pagination
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM product";
if ($startDate) {
    $totalRecordsQuery .= " WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
}
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Build the SQL query
$sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name, v.username AS vendor_name
        FROM product p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        LEFT JOIN vendors v ON p.vendor_id = v.id";

if ($startDate && $endDate) {
    $sql .= " WHERE DATE(p.created_at) BETWEEN '$startDate' AND '$endDate'";
}

// Add the ORDER BY clause to sort by date in descending order
$sql .= " ORDER BY p.created_at DESC LIMIT $startFrom, $recordsPerPage";

$result = $conn->query($sql);

include "product_header.php";
?>

<div class="d-flex justify-content-between align-items-center mb-3">
                <h1 style="font-size: 25px;">Manage Products</h1>
                <a href="generate_Product_View_pdf.php?start_date=<?= htmlspecialchars($startDate) ?>&end_date=<?= htmlspecialchars($endDate) ?>" class="btn btn-secondary ms-2">
                    <i class="fas fa-download me-2"></i> Download PDF
                </a>
</div>
            
<div class="d-flex justify-content-between align-items-center mb-3">
                <form action="product_view.php" method="GET" class="w-100" onsubmit="return validateDates()">
                    <div class="d-flex align-items-center w-100">
                        <div class="mb-3 input-groups me-2 flex-grow-1">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>" required>
                        </div>
                        <div class="mb-3 input-groups me-2 flex-grow-1">
                            <label for="end_date" class="form-label">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success btn-generate-report">Generate Report</button>
                        </div>
                    </div>
                </form>
</div>
            
<?php
include "db.php";

// Fetch category names and IDs from the categories table
$categoriesQuery = "SELECT id, name FROM categories";
$categoriesResult = $conn->query($categoriesQuery);

$categoryCounts = [];
$totalCategoryProducts = 0;

// Count products for each category
while ($category = $categoriesResult->fetch_assoc()) {
    $categoryId = $category['id'];
    $categoryName = $category['name'];

    // Get count of products in the current category
    $productCountQuery = "SELECT COUNT(*) AS count FROM product WHERE category_id = $categoryId";
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

// Fetch brand names and IDs from the brands table
$brandsQuery = "SELECT id, name FROM brands";
$brandsResult = $conn->query($brandsQuery);

$brandCounts = [];
$totalBrandProducts = 0;

// Count products for each brand
while ($brand = $brandsResult->fetch_assoc()) {
    $brandId = $brand['id'];
    $brandName = $brand['name'];

    // Get count of products in the current brand
    $productCountQuery = "SELECT COUNT(*) AS count FROM product WHERE brand_id = $brandId";
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

$conn->close();
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

<?php
include "product_mid.php";
?>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <?php if ($totalPages > 1): ?>
        <ul class="pagination justify-content-end">
            <!-- Previous page link -->
            <li class="page-item <?= $page > 1 ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $page > 1 ? 'product_view.php?page=' . ($page - 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Previous</a>
            </li>

            <!-- Page numbers -->
            <?php
            // Calculate the range to display only 3 pages
            $start = max(1, $page - 1); // Show 1 page before the current page
            $end = min($totalPages, $page + 1); // Show 1 page after the current page

            // Adjust range to always display 3 pages if possible
            if ($end - $start < 2) {
                if ($start > 1) {
                    $start = max(1, $start - (2 - ($end - $start)));
                }
                if ($end < $totalPages) {
                    $end = min($totalPages, $end + (2 - ($end - $start)));
                }
            }

            for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="product_view.php?page=<?= $i ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next page link -->
            <li class="page-item <?= $page < $totalPages ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $page < $totalPages ? 'product_view.php?page=' . ($page + 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Next</a>
            </li>
        </ul>
    <?php endif; ?>
</nav>

<?php
include "product_footer.php";
?>
