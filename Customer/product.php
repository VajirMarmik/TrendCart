<?php
include "db.php";
include "header.php";

// Define the number of results per page
$resultsPerPage = 9;

// Determine the current page and calculate the offset for the SQL LIMIT clause
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $resultsPerPage;

// Fetch product names
$productSql = "SELECT DISTINCT product_name FROM product";
$productResult = $conn->query($productSql);

// Fetch categories
$categorySql = "SELECT * FROM categories";
$categoryResult = $conn->query($categorySql);

// Fetch brands
$brandSql = "SELECT * FROM brands";
$brandResult = $conn->query($brandSql);

// Fetch types
$typeSql = "SELECT DISTINCT type FROM product";
$typeResult = $conn->query($typeSql);

// Fetch sizes
$sizeSql = "SELECT DISTINCT size FROM product";
$sizeResult = $conn->query($sizeSql);

// Fetch colors
$colorSql = "SELECT DISTINCT color FROM product";
$colorResult = $conn->query($colorSql);

// Check if a filter is selected
$selectedProduct = isset($_POST['productSelect']) ? $_POST['productSelect'] : '';
$selectedCategoryId = isset($_POST['categorySelect']) ? intval($_POST['categorySelect']) : 0;
$selectedBrandId = isset($_POST['brandSelect']) ? intval($_POST['brandSelect']) : 0;
$selectedType = isset($_POST['typeSelect']) ? $_POST['typeSelect'] : '';
$selectedSize = isset($_POST['sizeSelect']) ? $_POST['sizeSelect'] : '';
$selectedColor = isset($_POST['colorSelect']) ? $_POST['colorSelect'] : '';

// Get min and max price inputs
$minPrice = isset($_POST['minPrice']) ? floatval($_POST['minPrice']) : 0;
$maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : PHP_INT_MAX;

// SQL query for product filtering
$sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name 
        FROM product p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN brands b ON p.brand_id = b.id
        WHERE p.status = 'verified'";

// Add filters to SQL query
if (!empty($selectedProduct)) {
    $sql .= " AND p.product_name = '$selectedProduct'";
}
if ($selectedCategoryId > 0) {
    $sql .= " AND p.category_id = $selectedCategoryId";
}
if ($selectedBrandId > 0) {
    $sql .= " AND p.brand_id = $selectedBrandId";
}
if (!empty($selectedType)) {
    $sql .= " AND p.type = '$selectedType'";
}
if (!empty($selectedSize)) {
    $sql .= " AND p.size = '$selectedSize'";
}
if (!empty($selectedColor)) {
    $sql .= " AND p.color = '$selectedColor'";
}
if ($minPrice > 0) {
    $sql .= " AND p.price >= $minPrice";
}
if ($maxPrice < PHP_INT_MAX) {
    $sql .= " AND p.price <= $maxPrice";
}

// Count total results for pagination
$totalResultsQuery = "SELECT COUNT(*) as total FROM ($sql) as temp";
$totalResults = $conn->query($totalResultsQuery)->fetch_assoc()['total'];

// Pagination
$totalPages = ceil($totalResults / $resultsPerPage);
$sql .= " ORDER BY p.created_at DESC LIMIT $offset, $resultsPerPage"; 

$result = $conn->query($sql);

if (!$result) {
    die("Error fetching products: " . $conn->error);
}

// Start HTML output
?>

<!-- Product Section -->
<section id="product" class="section container">
    <div class="row mt-5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filters</h5>
                    <form method="POST" action="" id="filterForm">
                        <!-- Product Name Filter -->
                        <div class="mb-3">
                            <label for="productSelect" class="form-label">Product Name</label>
                            <select id="productSelect" name="productSelect" class="form-select" onchange="this.form.submit()">
                                <option value="">All Products</option>
                                <?php while ($row = $productResult->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['product_name']) ?>" <?= ($row['product_name'] == $selectedProduct) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['product_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="categorySelect" class="form-label">Category</label>
                            <select id="categorySelect" name="categorySelect" class="form-select" required onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <?php
                                if ($categoryResult->num_rows > 0) {
                                    while ($row = $categoryResult->fetch_assoc()) {
                                        $selected = ($row['id'] == $selectedCategoryId) ? 'selected' : '';
                                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No categories available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Brand Filter -->
                        <div class="mb-3">
                            <label for="brandSelect" class="form-label">Brand</label>
                            <select id="brandSelect" name="brandSelect" class="form-select" required onchange="this.form.submit()">
                                <option value="">All Brands</option>
                                <?php
                                if ($brandResult->num_rows > 0) {
                                    while ($row = $brandResult->fetch_assoc()) {
                                        $selected = ($row['id'] == $selectedBrandId) ? 'selected' : '';
                                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No brands available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div class="mb-3">
                            <label for="typeSelect" class="form-label">Type</label>
                            <select id="typeSelect" name="typeSelect" class="form-select" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <?php
                                if ($typeResult->num_rows > 0) {
                                    while ($row = $typeResult->fetch_assoc()) {
                                        $selected = ($row['type'] == $selectedType) ? 'selected' : '';
                                        echo "<option value='{$row['type']}' $selected>{$row['type']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No types available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Size Filter -->
                        <div class="mb-3">
                            <label for="sizeSelect" class="form-label">Size</label>
                            <select id="sizeSelect" name="sizeSelect" class="form-select" onchange="this.form.submit()">
                                <option value="">All Sizes</option>
                                <?php
                                if ($sizeResult->num_rows > 0) {
                                    while ($row = $sizeResult->fetch_assoc()) {
                                        $selected = ($row['size'] == $selectedSize) ? 'selected' : '';
                                        echo "<option value='{$row['size']}' $selected>{$row['size']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No sizes available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Color Filter -->
                        <div class="mb-3">
                            <label for="colorSelect" class="form-label">Color</label>
                            <select id="colorSelect" name="colorSelect" class="form-select" onchange="this.form.submit()">
                                <option value="">All Colors</option>
                                <?php
                                if ($colorResult->num_rows > 0) {
                                    while ($row = $colorResult->fetch_assoc()) {
                                        $selected = ($row['color'] == $selectedColor) ? 'selected' : '';
                                        echo "<option value='{$row['color']}' $selected>{$row['color']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No colors available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Price Range Slider -->
                        <div class="mb-3">
                            <label for="priceRange" class="form-label">Price Range</label>
                            <input type="range" id="priceRange" name="priceRange" min="0" max="1000" value="<?php echo htmlspecialchars($maxPrice); ?>" class="form-range" oninput="updatePriceRange(this.value)">
                            <p>Selected Max Price: <span id="rangeValue"><?php echo htmlspecialchars($maxPrice); ?></span></p>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-3">
                            <label for="minPrice" class="form-label">Min Price</label>
                            <input type="number" id="minPrice" name="minPrice" class="form-control" placeholder="0" min="0" value="<?php echo htmlspecialchars($minPrice); ?>" onchange="this.form.submit()">
                        </div>
                        <div class="mb-3">
                            <label for="maxPrice" class="form-label">Max Price</label>
                            <input type="number" id="maxPrice" name="maxPrice" class="form-control" placeholder="Maximum" min="0" value="<?php echo htmlspecialchars($maxPrice); ?>" onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Listings Section -->
        <div class="col-md-9">
            <div class="row">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4 custom-card-margin">
                            <div class="card">
                                <img class="card-img-top" src="<?= file_exists($row['photo_path']) ? htmlspecialchars($row['photo_path']) : 'images/default_product.jpg' ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" style="height: 200px; object-fit: contain;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['product_name']) ?></h5> 
                                    <p class="card-text fw-bold">₹<?= htmlspecialchars($row['price']) ?></p>
                                    <a href="product_details.php?id=<?= $row['product_id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                                    <!-- <a href="order.php?id=<?= $row['product_id']; ?>" class="btn btn-primary btn-sm">Buy</a> -->
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class='text-center'>No products found.</p>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <?php if ($totalPages > 1): ?>
                    <ul class="pagination justify-content-end">
                        <!-- Previous page link -->
                        <li class="page-item <?= $page > 1 ? '' : 'disabled' ?>">
                            <a class="page-link" href="<?= $page > 1 ? '?page=' . ($page - 1) : '#' ?>">Previous</a>
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
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next page link -->
                        <li class="page-item <?= $page < $totalPages ? '' : 'disabled' ?>">
                            <a class="page-link" href="<?= $page < $totalPages ? '?page=' . ($page + 1) : '#' ?>">Next</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>

        </div>
    </div>
</section>

<?php include "footer.php"; ?>

<!-- Custom CSS for spacing -->
<style>
.custom-card-margin {
    margin-bottom: 15px;
}
.form-select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
</style>


<!-- JavaScript to update the price range display -->
<script>
function updatePriceRange(value) {
    document.getElementById('rangeValue').textContent = value;
    document.getElementById('maxPrice').value = value; // Update the max price input
    document.getElementById('filterForm').submit(); // Submit the form to filter products
}
</script>
