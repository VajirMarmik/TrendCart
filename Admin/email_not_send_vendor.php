<?php 
    include "vendor_header.php"; 
    include "db.php";

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
    $totalRecordsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE `verification_status` = 'Not Verified'";
    if ($startDate) {
        $totalRecordsQuery .= " AND DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
    }
    $totalRecordsResult = $conn->query($totalRecordsQuery);
    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Query to fetch vendor records with verification_status = 'Not Verified'
    $sql = "SELECT * FROM `vendors` WHERE `verification_status` = 'Not Verified'";
    
    // If a date range is specified, append the date range condition
    if ($startDate && $endDate) {
        $sql .= " AND DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
    }

    // Add pagination limit
    $sql .= " ORDER BY created_at DESC LIMIT $startFrom, $recordsPerPage";
    
    $result = mysqli_query($conn, $sql);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 style="font-size: 25px;">Vendor Verification Pending</h1>
    <a href="generate_Vendor_Verification_Pending_pdf.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>" class="btn btn-secondary ms-2">
        <i class="fas fa-download me-2"></i> Download PDF
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form id="reportForm" action="email_not_send_vendor.php" method="GET" class="w-100">
        <div class="d-flex align-items-center w-100">
            <div class="mb-3 input-groups me-2 flex-grow-1">
                    <label for="start_date" class="form-label"><b>Start Date:</b></label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>" required>
            </div>
            <div class="mb-3 input-groups me-2 flex-grow-1">
                    <label for="end_date" class="form-label"><b>End Date:</b></label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-success btn-generate-report">Generate Report</button>
            </div>
        </div>
    </form>
</div>

<?php
include "db.php";

// Fetch the count of vendors per subscription plan dynamically, where is_verified = 'joined'
$planCounts = [];
$planPercentages = [];

// Total vendors count with is_verified = 'joined'
$totalVendorsQuery = "SELECT COUNT(*) AS total FROM vendors WHERE`verification_status` = 'Not Verified'";
$totalVendorsResult = $conn->query($totalVendorsQuery);
$totalVendors = $totalVendorsResult->fetch_assoc()['total'];

// Get count for each plan, filtering by is_verified = 'joined'
$planQuery = "SELECT make_plan, COUNT(*) AS count FROM vendors WHERE`verification_status` = 'Not Verified' GROUP BY make_plan";
$planResult = $conn->query($planQuery);

while ($row = $planResult->fetch_assoc()) {
    $planCounts[$row['make_plan']] = $row['count'];
}

// Calculate percentage for each plan
foreach ($planCounts as $plan => $count) {
    $planPercentages[$plan] = $totalVendors > 0 ? ($count / $totalVendors) * 100 : 0;
}

$conn->close();
?>

<div class="container mb-3">
    <!-- First Chart Card -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5><b>Subscription Plan Distribution</b></h5>
                </div>
                <div class="card-body">
                    <div style="width: 250px; margin: 0 auto;">
                        <canvas id="planChart" style="max-width: 100%; height: auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Plan labels and data
    const planLabels = <?php echo json_encode(array_keys($planPercentages)); ?>;
    const planData = <?php echo json_encode(array_values($planPercentages)); ?>;

    // Generate a color for each plan dynamically
    function getRandomColor() {
        return `#${Math.floor(Math.random()*16777215).toString(16).padStart(6, '0')}`;
    }
    const colors = planLabels.map(() => getRandomColor());

    // Generate the pie chart
    const ctx = document.getElementById('planChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: planLabels,
            datasets: [{
                label: 'Subscription Plan Distribution',
                data: planData,
                backgroundColor: colors,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'left',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return planLabels[tooltipItem.dataIndex] + ': ' + planData[tooltipItem.dataIndex].toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });
</script>

<?php
    include "vendor_mid.php";
?>

<!-- Pagination -->
<nav aria-label="Page navigation">
    <?php if ($totalPages > 1): ?>
        <ul class="pagination justify-content-end">
            <!-- Previous page link -->
            <li class="page-item <?= $page > 1 ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $page > 1 ? 'email_not_send_vendor.php?page=' . ($page - 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Previous</a>
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
                    <a class="page-link" href="email_not_send_vendor.php?page=<?= $i ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next page link -->
            <li class="page-item <?= $page < $totalPages ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $page < $totalPages ? 'email_not_send_vendor.php?page=' . ($page + 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Next</a>
            </li>
        </ul>
    <?php endif; ?>
</nav>

<?php 
    include "vendor_footer.php"; 
?>
