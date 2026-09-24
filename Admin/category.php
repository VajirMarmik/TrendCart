<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

date_default_timezone_set("Asia/Kolkata");
include "db.php";

// Pagination logic
$recordsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $recordsPerPage;

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($startDate && !$endDate) {
    $endDate = date('Y-m-d');
}

$sql = "SELECT * FROM categories";
if ($startDate) {
    $sql .= " WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
}
$sql .= " ORDER BY created_at DESC LIMIT $startFrom, $recordsPerPage";

$result = $conn->query($sql);

// Get total records for pagination
$totalRecordsQuery = "SELECT COUNT(*) AS total FROM categories";
if ($startDate) {
    $totalRecordsQuery .= " WHERE DATE(created_at) BETWEEN '$startDate' AND '$endDate'";
}
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

// Check for status query parameter
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrendCart - Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        .form-label {
            font-weight: bold;
        }
        .btn-generate-report {
            background-color: #28a745;
            border-color: #28a745;
            white-space: nowrap;
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
        .btn-generate-report:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .modal-body {
            background: #fff; 
            padding: 20px; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .modal-body h2 {
            margin-top: 0;
            color: #333;
        }

        .modal-body input {
            width: 100%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }

        .modal-body input.input-error {
            border-color: red;
        }

        .modal-body input.input-success {
            border-color: green;
        }

        .modal-body button {
            padding: 10px; 
            background-color: #007BFF; 
            border: none; 
            border-radius: 4px; 
            color: #fff; 
            font-size: 16px;
        }

        .modal-body button:hover {
            background-color: #0056b3;
        }

        .modal-body .error {
            color: red; 
            margin-top: 10px;
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
            <?php  include "dashboard_min.php"; ?>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 style="font-size: 25px;">Manage Category</h1>
                <div>
                    <button type="button" class="btn btn-primary btn-add-category" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fas fa-plus me-2"></i> Add Category
                    </button>
                    <a href="generate_category_pdf.php?start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>" class="btn btn-secondary ms-2">
                        <i class="fas fa-download me-2"></i> Download PDF
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <form id="reportForm" action="category.php" method="GET" class="w-100">
                    <div class="d-flex align-items-center w-100">
                        <div class="mb-3 input-groups me-2 flex-grow-1">
                            <label for="start_date" class="form-label">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>" required>
                        </div>
                        <div class="mb-3 input-groups me-2 flex-grow-1">
                            <label for="end_date" class="form-label">End Date:</label>
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
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $serialNumber = $startFrom + 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$serialNumber}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['created_at']}</td>
                                        <td>
                                            <a href='#' class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'>
                                                <i class='fa fa-trash-o' aria-hidden='true' title='Delete Category'></i>
                                            </a>
                                        </td>
                                    </tr>";
                                    $serialNumber++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No categories found for selected date range</td></tr>";
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
                            <a class="page-link" href="<?= $page > 1 ? 'category.php?page=' . ($page - 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Previous</a>
                        </li>

                        <!-- Page numbers -->
                        <?php
                        // Determine the start and end of the range
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
                                <a class="page-link" href="category.php?page=<?= $i ?>&start_date=<?= urlencode($startDate) ?>&end_date=<?= urlencode($endDate) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next page link -->
                        <li class="page-item <?= $page < $totalPages ? '' : 'disabled' ?>">
                            <a class="page-link" href="<?= $page < $totalPages ? 'category.php?page=' . ($page + 1) . '&start_date=' . urlencode($startDate) . '&end_date=' . urlencode($endDate) : '#' ?>">Next</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </nav>

        </div>

        <!-- Add Category Modal -->
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="add_category.php" onsubmit="return validate_category();">
                            <label id="category-label" for="categoryName" class="form-label">Category Name</label>
                            <input type="text" id="category" name="category" placeholder="Category Name" required oninput="validate_category()">
                            <div id="category-error" class="error" style="margin-bottom: 5px;"></div>
                            <button type="submit" style='margin-top: 10px;'>Add Category</button>
                            <?php if (isset($error)) { echo "<p class='error' >$error</p>"; } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    <?php if ($status === 'success'): ?>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Category Added Successfully',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.replaceState({}, '', url);
        });
    <?php elseif ($status === 'error'): ?>
        Swal.fire({
            title: 'Error!',
            text: 'There was a problem adding the category.',
            icon: 'error'
        }).then(() => {
            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.replaceState({}, '', url);
        });
    <?php elseif ($status === 'duplicate'): ?>
        Swal.fire({
            title: 'Duplicate Category!',
            text: 'You have already added this category.',
            icon: 'warning'
        }).then(() => {
            let url = new URL(window.location.href);
            url.searchParams.delete('status');
            window.history.replaceState({}, '', url);
        });
    <?php endif; ?>

    function validate_category() {
        var categoryF = document.getElementById("category");
        var categoryE = document.getElementById("category-error");
        var categoryPattern = /^[a-zA-Z\s]+$/; // Allows only letters and spaces
        var maxLength = 30; // Maximum length for the category name

        if (categoryF.value.length > maxLength) {
            categoryE.innerHTML = `Category name must be up to ${maxLength} characters long.`;
            categoryF.classList.add("input-error");
            categoryF.classList.remove("input-success");
            return false;
        } else if (!categoryF.value.match(categoryPattern)) {
            categoryE.innerHTML = "Please enter a valid category name (only letters and spaces allowed).";
            categoryF.classList.add("input-error");
            categoryF.classList.remove("input-success");
            return false;
        } else {
            categoryE.innerHTML = "";
            categoryF.classList.remove("input-error");
            categoryF.classList.add("input-success");
            return true;
        }
    }

    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this category?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success alert before redirecting
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Category Deleted Successfully',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    // Redirect after success alert is displayed
                    window.location.href = `delete_category.php?id=${categoryId}&status=deleted`;
                });
            }
        });
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
