<?php
// session_start(); // Start the session
include 'db.php'; // Include the database connection
include 'header.php'; // Include the header

// Get the product ID from the URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details from the database
$query = "SELECT * FROM product WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // Display product details
    ?>


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm border-0 p-3" style="padding: 5px;">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <img src="<?php echo htmlspecialchars($product['photo_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid mt-1">
                        <ul class="list-unstyled mt-4 text-center">
                            <li><strong>Size: </strong><?php echo htmlspecialchars($product['size']); ?></li>
                            <li><strong>Color: </strong><?php echo htmlspecialchars($product['color']); ?></li>
                            <li><strong>Type: </strong><?php echo htmlspecialchars($product['type']); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body d-flex flex-column">
                            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            <h4 class="fw-bold">₹<?php echo htmlspecialchars($product['price']); ?></h4>
                            <!-- Quantity Section -->
                            <div class="mb-3">
                                <label for="quantity" class="form-label"><strong>Quantity</strong></label>
                                <div class="input-group full-width-group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                    <input type="text" id="quantity" class="form-control text-center" value="1" readonly>
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>

                            <!-- Add to Cart and Buy Buttons -->
                            <div class="mt-auto d-flex">
                                <button class="btn btn-success w-100 me-2" onclick="addToCart(<?php echo $productId; ?>, '<?php echo htmlspecialchars($product['product_name']); ?>', <?php echo htmlspecialchars($product['price']); ?>)">Add to Cart</button>
                                <a href="#" class="btn btn-secondary w-100">Buy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        function increaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            if (currentValue < 6) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            var quantityInput = document.getElementById('quantity');
            var currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        function addToCart(productId, productName, price) {
            var quantity = parseInt(document.getElementById('quantity').value);
            var totalPrice = price * quantity;

            // Make an AJAX call to add the item to the cart
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add_to_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    window.location.href = 'cart.php'; // Redirect to the cart page
                }
            };
            xhr.send('id=' + productId + '&name=' + encodeURIComponent(productName) + '&price=' + price + '&quantity=' + quantity + '&totalPrice=' + totalPrice);
        }
    </script>

    <?php
} else {
    echo "<div class='container mt-5'><h2>Product not found.</h2></div>";
}

// Close the database connection
$stmt->close();
$conn->close();

include 'footer.php'; // Include the footer
?>

<!-- Full-screen custom CSS for the input group -->
<style>
    .full-width-group {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 300px;
    }

    .input-group button {
        width: 40px;
    }

    #quantity {
        width: 60px;
    }

    .btn-block {
        width: 100%;
    }
</style>
