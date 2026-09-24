    <?php
    // Fetch categories
    $categorySql = "SELECT * FROM categories";
    $categoryResult = $conn->query($categorySql);

    // Fetch brands
    $brandSql = "SELECT * FROM brands";
    $brandResult = $conn->query($brandSql);

    ?>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <form id="addProductForm" enctype="multipart/form-data"> -->
                <form id="addProductForm" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">

                        <!-- Category Selection -->
                        <div class="mb-3">
                            <label for="categorySelect" class="form-label">Select Category *</label>
                            <select id="categorySelect" name="categorySelect" class="form-select" required>
                                <option value="">Select a category</option>
                                <?php
                                if ($categoryResult->num_rows > 0) {
                                    while ($row = $categoryResult->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No categories available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Brand Selection -->
                        <div class="mb-3">
                            <label for="brandSelect" class="form-label">Select Brand *</label>
                            <select id="brandSelect" name="brandSelect" class="form-select" required>
                                <option value="">Select a brand</option>
                                <?php
                                if ($brandResult->num_rows > 0) {
                                    while ($row = $brandResult->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No brands available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name *</label>
                            <input type="text" class="form-control" id="productName" name="product_name" placeholder="Product Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productSize" class="form-label">Product Size *</label>
                            <input type="number" class="form-control" id="productSize" name="product_size" placeholder="Product Size" required>
                        </div>
                        <div class="mb-3">
                            <label for="productColor" class="form-label">Product Color *</label>
                            <input type="text" class="form-control" id="productColor" name="product_color" placeholder="Product Color" required>
                        </div>
                        <div class="mb-3">
                            <label for="productType" class="form-label">Product Type *</label>
                            <input type="text" class="form-control" id="productType" name="product_type" placeholder="Product Type" required>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description *</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3" placeholder="Product Description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price *</label>
                            <input type="number" step="0.01" class="form-control" id="productPrice" name="price" placeholder="Product Price" required>
                        </div>
                        <div class="mb-3">
                            <!-- <label for="photo">Photo Upload</label>
                            <input type="file" name="photo" id="photo" accept="image/*" required> -->
                            <label for="photo">Photo Upload *</label>
                            <input type="file" class="form-control" name="photo" id="photo" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Product Modal -->
    <div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateProductForm">
                    <input type="hidden" id="updateProductId" name="product_id">
                    <div class="modal-body">
                        <!-- Category Selection -->
                        <div class="mb-3">
                            <label for="updateCategorySelect" class="form-label">Select Category</label>
                            <select id="updateCategorySelect" name="categorySelect" class="form-select" required>
                                <option value="">Select a category</option>
                                <?php
                                // Fetch categories from the database
                                include "db.php";
                                $categorySql = "SELECT * FROM categories";
                                $categoryResult = $conn->query($categorySql);
                                if ($categoryResult->num_rows > 0) {
                                    while ($row = $categoryResult->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No categories available</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>

                        <!-- Brand Selection -->
                        <div class="mb-3">
                            <label for="updateBrandSelect" class="form-label">Select Brand</label>
                            <select id="updateBrandSelect" name="brandSelect" class="form-select" required>
                                <option value="">Select a brand</option>
                                <?php
                                // Fetch brands from the database
                                include "db.php";
                                $brandSql = "SELECT * FROM brands";
                                $brandResult = $conn->query($brandSql);
                                if ($brandResult->num_rows > 0) {
                                    while ($row = $brandResult->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No brands available</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>

                        <!-- Existing Fields -->
                        <div class="mb-3">
                            <label for="updateProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="updateProductName" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductSize" class="form-label">Product Size</label>
                            <input type="number" class="form-control" id="updateProductSize" name="product_size" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductColor" class="form-label">Product Color</label>
                            <input type="text" class="form-control" id="updateProductColor" name="product_color" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductType" class="form-label">Product Type</label>
                            <input type="text" class="form-control" id="updateProductType" name="product_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateProductDescription" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="updateProductPrice" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="updateProductPrice" name="price" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Handle the "Add Product" form submission
        // $('#addProductForm').on('submit', function(event) {
        //     event.preventDefault();
           
        //     $.ajax({
        //         url: 'add_product.php',
        //         type: 'POST',
        //         data: $(this).serialize(),
        //         success: function(response) {
        //             Swal.fire({
        //                 position: 'top-end',
        //                 icon: 'success',
        //                 title: 'Product added successfully!',
        //                 showConfirmButton: false,
        //                 timer: 2000
        //             }).then(() => {
        //                 $('#addProductModal').modal('hide');
        //                 location.reload(); // Reload the page to reflect the new product
        //             });
        //         },
        //         error: function(xhr, status, error) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Oops...',
        //                 text: 'Something went wrong! Please try again.'
        //             });
        //         }
        //     });
        // });

        // Populate the "Update Product" modal with product data
        $('#updateProductModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var description = button.data('description');
            var price = button.data('price');
            var categoryId = button.data('category-id');
            var brandId = button.data('brand-id');
            var size = button.data('size');
            var color = button.data('color');
            var type = button.data('type');

            var modal = $(this);
            modal.find('#updateProductId').val(id);
            modal.find('#updateProductName').val(name);
            modal.find('#updateProductDescription').val(description);
            modal.find('#updateProductPrice').val(price);
            modal.find('#updateCategorySelect').val(categoryId);
            modal.find('#updateBrandSelect').val(brandId);
            modal.find('#updateProductSize').val(size);
            modal.find('#updateProductColor').val(color);
            modal.find('#updateProductType').val(type);
        });

        // Handle the "Update Product" form submission
        $('#updateProductForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: 'update_product.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Product updated successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        $('#updateProductModal').modal('hide');
                        location.reload(); // Reload the page to reflect the updated product
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again.'
                    });
                }
            });
        });

        // Handle product deletion
        $('.delete-btn').on('click', function() {
            var productId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_product.php',
                        type: 'POST',
                        data: { product_id: productId },
                        success: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Product deleted successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                location.reload(); // Reload the page to reflect the deleted product
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong! Please try again.'
                            });
                        }
                    });
                }
            });
        });
    
        // Function to validate the dates
        function validateDates() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate > endDate && startDate && endDate) {
                // Show SweetAlert if start date is greater than end date
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Start date cannot be greater than end date!',
                    confirmButtonText: 'OK'
                });
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>


</body>
</html>

<?php
// session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: index.php');
//     exit();
// }

include "db.php";

// Get the vendor ID
$vendorUsername = $_SESSION['username'];
$vendorQuery = "SELECT id FROM vendors WHERE username = '$vendorUsername'";
$vendorResult = $conn->query($vendorQuery);
$vendorRow = $vendorResult->fetch_assoc();
$vendorId = $vendorRow['id'];

// Collect data from POST request
$productName = mysqli_real_escape_string($conn, $_POST['product_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$categoryId = mysqli_real_escape_string($conn, $_POST['categorySelect']);
$brandId = mysqli_real_escape_string($conn, $_POST['brandSelect']);
$productSize = mysqli_real_escape_string($conn, $_POST['product_size']);
$productColor = mysqli_real_escape_string($conn, $_POST['product_color']);
$productType = mysqli_real_escape_string($conn, $_POST['product_type']);

$photo = $_FILES['photo']['name'];
$target_dir = "../uploads/";

// Check if the uploads directory exists, if not create it
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$photo_file = $target_dir . basename($photo);

// Upload files
move_uploaded_file($_FILES['photo']['tmp_name'], $photo_file);

// echo "<script> 
//                         alert('$photo');
//                     </script>";

// Insert product into the database
$sql = "INSERT INTO product (vendor_id, product_name, description, price, category_id, brand_id, size, color, type, photo_path) 
        VALUES ($vendorId, '$productName', '$description', '$price', '$categoryId', '$brandId', '$productSize', '$productColor', '$productType', '$photo_file')";
if ($conn->query($sql) === TRUE) {
    // echo "Success";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>