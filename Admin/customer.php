<?php 
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

date_default_timezone_set("Asia/Kolkata");
include "db.php";

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
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM customer";
if ($startDate && $endDate) {
    $totalRecordsQuery .= " WHERE DATE(registered_date) BETWEEN '$startDate' AND '$endDate'";
}

$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Base SQL query
$sql = "SELECT * FROM `customer`";

// If a date range is specified, append the date range condition
if ($startDate && $endDate) {
    $sql .= " WHERE DATE(registered_date) BETWEEN '$startDate' AND '$endDate'";
}

// Add pagination limit
$sql .= " ORDER BY registered_date DESC LIMIT $startFrom, $recordsPerPage";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Manage Customers</title>
    <style>
        .download-btn {
            float: right;
            margin: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .verify-btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include "admin_sidebar.php"; ?>
    <div class="main p-3">
        <div class="text-center">
            <h1 style="font-size: 30px;">Welcome to Admin</h1>
        </div>
        <div class="container mt-3">
            <?php include "dashboard_min.php"; ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 style="font-size: 25px;">Manage Customers</h1>
                <a href="generate_Customer_pdf.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>" class="btn btn-secondary ms-2">
                    <i class="fas fa-download me-2"></i> Download PDF
                </a>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form id="reportForm" action="customer.php" method="GET" class="w-100">
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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SR. No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registered Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through all customer records and display them
                        if ($result->num_rows > 0) {
                            $sr_no = $startFrom + 1; // Start numbering from $startFrom + 1
                            while ($user = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $sr_no++ . "</td>"; // Display the serial number and increment it
                                echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($user['registered_date']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No Customers found for selected date range</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <?php if ($totalPages > 1): ?>
                    <ul class="pagination justify-content-end">
                        <!-- Previous page link -->
                        <li class="page-item <?= $page > 1 ? '' : 'disabled' ?>">
                            <a class="page-link" href="<?= $page > 1 ? 'customer.php?page=' . ($page - 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Previous</a>
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
                                <a class="page-link" href="customer.php?page=<?= $i ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next page link -->
                        <li class="page-item <?= $page < $totalPages ? '' : 'disabled' ?>">
                            <a class="page-link" href="<?= $page < $totalPages ? 'customer.php?page=' . ($page + 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Next</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>
        </div>
    </div>
</div>

<!-- Modal to display full-size image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full Size Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openModal(imageSrc) {
        // Set the source of the image in the modal
        document.getElementById('modalImage').src = imageSrc;
        // Show the modal
        var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    document.getElementById('reportForm').onsubmit = function () {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        if (startDate > endDate && startDate && endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Start date cannot be greater than end date!'
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    };
</script>
</body>
</html>
