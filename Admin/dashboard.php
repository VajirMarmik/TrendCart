<?php
session_start();
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
    <title>TrendCart - Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="wrapper">
        <?php include "admin_sidebar.php"; ?>

        <div class="main p-3">
            
            <div class="text-center">
                <h1 style="font-size: 30px;">Welcome to Admin Dashboard</h1>
            </div>

            <div class="container mt-3">
                <?php include "dashboard_min.php"; ?>
            </div>

            <?php
                // Include database connection
                include "db.php";

                // Count vendors from the vendors table
                $vendorCountQuery = "SELECT COUNT(*) AS count FROM vendors";
                $vendorCountResult = $conn->query($vendorCountQuery);
                $vendorCount = $vendorCountResult->fetch_assoc()['count'];

                // Count customers from the customers table
                $customerCountQuery = "SELECT COUNT(*) AS count FROM customer";
                $customerCountResult = $conn->query($customerCountQuery);
                $customerCount = $customerCountResult->fetch_assoc()['count'];

                // Total count of vendors and customers
                $totalCount = $vendorCount + $customerCount;

                // Calculate percentages
                $vendorPercentage = $totalCount > 0 ? ($vendorCount / $totalCount) * 100 : 0;
                $customerPercentage = $totalCount > 0 ? ($customerCount / $totalCount) * 100 : 0;

                // Fetch the count of vendors per subscription plan dynamically
                $planCounts = [];
                $planPercentages = [];

                // Total vendors count
                $totalVendorsQuery = "SELECT COUNT(*) AS total FROM vendors";
                $totalVendorsResult = $conn->query($totalVendorsQuery);
                $totalVendors = $totalVendorsResult->fetch_assoc()['total'];

                // Get count for each plan
                $planQuery = "SELECT make_plan, COUNT(*) AS count FROM vendors GROUP BY make_plan";
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

            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5><b>Subscription Plan Distribution</b></h5>
                            </div>
                            <div class="card-body">
                                <!-- <div style="width: 300px; height: 300px; margin: 0 auto;"> -->
                                    <canvas id="planChart"></canvas>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- Second Chart Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5><b>Total Users Distribution</b></h5>
                            </div>
                            <div class="card-body">
                                <canvas id="vendorCustomerChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Data for the second chart
                const planLabels = <?php echo json_encode(array_keys($planPercentages)); ?>;
                const planData = <?php echo json_encode(array_values($planPercentages)); ?>;

                // Generate dynamic colors for the second chart
                const colors = planLabels.map(() => {
                    return `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`;
                });

                // Create the second pie chart
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

                // Data for the bar chart
                const barLabels = ['Vendors', 'Customers'];
                const barCounts = [
                    <?php echo $vendorCount; ?>,
                    <?php echo $customerCount; ?>
                ];
                const barPercentages = [
                    <?php echo $vendorPercentage; ?>,
                    <?php echo $customerPercentage; ?>
                ];

                // Generate dynamic colors for the bar chart
                const barColors = barLabels.map(() => {
                    return `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`;
                });

                // Create the bar chart
                new Chart(document.getElementById('vendorCustomerChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: [{
                            label: 'Total Users',
                            data: barCounts,
                            backgroundColor: barColors,
                            borderColor: barColors,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }, // Disable legend for simplicity
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        // Get the current label
                                        const label = barLabels[tooltipItem.dataIndex];
                                        // Get the count and percentage
                                        const count = barCounts[tooltipItem.dataIndex];
                                        const percentage = barPercentages[tooltipItem.dataIndex].toFixed(2);
                                        // Return customized text
                                        return `${count} ${label} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'User Type',
                                    font: { weight: 'bold' }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Users',
                                    font: { weight: 'bold' }
                                }
                            }
                        }
                    }
                });
            </script>

            <?php
                // Include database connection
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

            <div class="container my-5">
                <div class="row">
                    <!-- Third Chart Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5><b>Category Distribution</b></h5>
                            </div>
                            <div class="card-body">
                                <!-- <div style="width: 300px; height: 300px; margin: 0 auto;"> -->
                                    <canvas id="categoryChart" style="max-width: 100%; height: auto;"></canvas>
                                <!-- </div> -->
                            </div>    
                        </div>
                    </div>

                    <!-- Forth Chart Card -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5><b>Brand Distribution</b></h5>
                            </div>
                            <div class="card-body">
                                <!-- <div style="width: 300px; height: 300px; margin: 0 auto;"> -->
                                    <canvas id="brandChart" style="max-width: 100%; height: auto;"></canvas>
                                <!-- </div> -->
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

                // Generate dynamic colors for category chart
                const categoryColors = categoryLabels.map(() => {
                    return `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`;
                });

                // Create the category chart
                new Chart(document.getElementById('categoryChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            label: 'Category Distribution',
                            data: categoryData,
                            backgroundColor: categoryColors
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

                // Generate dynamic colors for brand chart
                const brandColors = brandLabels.map(() => {
                    return `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`;
                });

                // Create the brand chart
                new Chart(document.getElementById('brandChart').getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: brandLabels,
                        datasets: [{
                            label: 'Brand Distribution',
                            data: brandData,
                            backgroundColor: brandColors
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
