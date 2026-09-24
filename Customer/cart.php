<?php
session_start();
include 'db.php';
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header('Location: login.php');
    exit();
}

include 'header.php'; // Include the header

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $totalAmount = 0; // Initialize total amount
    
    ?>
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <table class="table table-bordered container">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Size</th>
                    <th>Color</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $key => $item) {
                    $totalAmount += $item['totalPrice'];

                    echo "<tr id='item-{$key}'>";
                    echo "<td><a href='product_details.php?id=" . htmlspecialchars($item['id']) . "' target='_blank'>
                            <img src='" . htmlspecialchars($item['photo_path']) . "' alt='" . htmlspecialchars($item['name']) . "' style='width: 100px; height: auto;'>
                          </a></td>";
                    echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($item['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($item['size']) . "</td>";
                    echo "<td>" . htmlspecialchars($item['color']) . "</td>";
                    echo "<td>" . htmlspecialchars($item['type']) . "</td>";
                    echo "<td>₹" . htmlspecialchars($item['price']) . "</td>";
                    echo "<td>
                            <input type='number' class='form-control quantity' value='" . htmlspecialchars($item['quantity']) . "' 
                                   onchange='updateTotalPrice($key, " . htmlspecialchars($item['price']) . ")' 
                                   min='1' max='6'>
                          </td>";
                    echo "<td id='total-price-{$key}'>₹" . htmlspecialchars($item['totalPrice']) . "</td>";
                    echo "<td><a href='remove_from_cart.php?id=$key' class='btn btn-danger'>Remove</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6 offset-md-6">
                <table class="table">
                    <tr>
                        <td><strong>Total Amount:</strong></td>
                        <td id="total-amount">₹<?php echo $totalAmount; ?></td>
                    </tr>
                </table>
                
                <div class="d-flex justify-content-between mt-3">
                    <a href="product.php" class="btn btn-secondary btn-lg">
                        <i class="fas fa-shopping-cart"></i> Continue Purchasing
                    </a>
                    <a href="#" class="btn btn-success btn-lg">
                        <i class="fas fa-check"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotalPrice(index, price) {
            var quantityInput = document.querySelector(`#item-${index} .quantity`);
            var quantity = parseInt(quantityInput.value);
            
            if (quantity < 1) {
                quantity = 1;
                quantityInput.value = quantity;
            } else if (quantity > 6) {
                quantity = 6;
                quantityInput.value = quantity;
            }

            var totalPrice = price * quantity;
            document.getElementById(`total-price-${index}`).innerText = '₹' + totalPrice;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('total-amount').innerText = '₹' + response.totalAmount;
                }
            };
            xhr.send('index=' + index + '&quantity=' + quantity + '&totalPrice=' + totalPrice);

            recalculateTotalAmount();
        }

        function recalculateTotalAmount() {
            var totalAmount = 0;
            var itemRows = document.querySelectorAll('tbody tr');

            itemRows.forEach(function(row) {
                var totalPriceElement = row.querySelector('[id^=total-price-]');
                var totalPriceText = totalPriceElement.innerText.replace('₹', '');
                var totalPrice = parseFloat(totalPriceText);
                totalAmount += totalPrice;
            });

            document.getElementById('total-amount').innerText = '₹' + totalAmount;
        }
    </script>

    <?php
} else {
    echo "<div class='container mt-5'><h2>Your cart is empty.</h2></div>";
}

include 'footer.php'; // Include the footer
?>
