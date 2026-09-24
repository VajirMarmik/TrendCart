<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

include "db.php";

// Set timezone
date_default_timezone_set("Asia/Kolkata");

// Get dates from the form input or set defaults
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($startDate && !$endDate) {
    $endDate = date('Y-m-d'); // Set endDate to today's date if not provided
}

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
$sql .= " ORDER BY p.created_at DESC";

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
include "product_footer.php";
?>
