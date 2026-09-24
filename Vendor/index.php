<?php
// Include your header if you have a separate header file
include "header.php";
?>

<!-- Custom CSS -->
<style>
    .card-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        padding: 10px 10px;
    }

    .custom-card {
        border-radius: 10px;
        padding: 20px;
        width: 200px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-card:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        border: 2px solid #0d6efd;
    }

    .custom-card h3 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .custom-card p {
        font-size: 16px;
    }

    .colorlib-loader {
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;
        width: 100%;
        height: 100%;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        color: #333;
    }

    .product-title {
        text-align: center;
        margin: 20px 0;
        font-size: 2rem;
        font-weight: bold;
    }

    .product-description {
        text-align: center;
        font-size: 1rem;
    }

    .custom-card-margin {
        margin-bottom: 20px;
    }

    .btn-success-hover:hover {
        background-color: #28a745;
        color: white;
    }

    .logo-container {
        padding: 40px;
        text-align: center;
    }

    .logo-container h2 {
        font-family: 'Arial', sans-serif;
        color: #666;
        margin-bottom: 40px;
        font-size: 1.5rem;
    }

    .logo-item {
        padding: 20px;
        border-radius: 10px;
        background-color: transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s;
    }

    .logo-item img {
        max-width: 200px;
        height: auto;
        max-height: 150px;
        object-fit: contain;
        aspect-ratio: 3/2;
    }

    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        border: none;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        border: 2px solid #0d6efd;
    }

    .faq-section h3 {
        margin-top: 4rem;
        margin-bottom: 2rem;
        color: #0d6efd;
    }

    .accordion-button:focus {
        box-shadow: none;
    }

    .crossed-price {
        text-decoration: line-through;
        color: #999;
        font-size: 1.25rem;
        display: block;
    }

    .yellow-dot {
        width: 15px;
        height: 15px;
        background-color: yellow;
        border-radius: 50%;
    }

    /* .btn-primary {
        border-radius: 25px;
        width: 30%;
        justify-content: center;
        align-items: center;
        display: flex;
        margin: 0 auto;
    }

    .btn-primary:hover {
        background-color: #084298;
        transition: background-color 0.3s ease-in-out;
    } */

    .btn {
        padding: 0.75rem;
        display: block;
        text-align: center;
        text-decoration: none;
        color: #f3f3f3;
        cursor: pointer;
        border-radius: 0.25rem;
        margin: 0; /* Removes margin to make button full width */
        width: 100%; /* Ensures button takes full width of the grid column */
        transition: all 250ms ease-in-out;
    }

    .btn:hover {
        box-shadow: 0 0 0 1.5px #fff, 0 0 0 3px #0000ff;
        background-color: #11ce1b;
        color: black;
        font-size: 20px;
    }

    .btn0 {
        border-radius: 25px;
        width: 20%;
        justify-content: center;
        display: flex;
        margin: 0px 25px;
    }

    .btn1 {
        align-items: left;
    }

    .btn2 {
        align-items: left;
    }

    .btn3 {
        align-items: center;
    }

    .btn4 {
        border-radius: 25px;
        width: 30%;
        justify-content: center;
        align-items: center;
        display: flex;
        margin: 0 auto;
    }

    /* .btn-primary:hover {
        background-color: #084298;
        transition: background-color 0.3s ease-in-out;
    } */

    /* Slide 1 Button Position */
    .caption-slide-1 {
        position: absolute;
        top: 0%;
        bottom: 10%;
        /* left: 0%; */
        /* right: 0%; */
        /* transform: translateX(-10%); */
    }

    /* Slide 2 Button Position */
    .caption-slide-2 {
        position: absolute;
        top: 0%;
        bottom: 30%;
        left: 0%; 
        right: 32%;
        /* transform: translateX(-50%); */
    }

    /* Slide 3 Button Position */
    .caption-slide-3 {
        position: absolute;
        top: 4%;
        /* bottom: 0px; */
        /* left: 0%; */
        /* right: 0%; */
        /* transform: translateX(15%); */
    }

    /* Optional: Style for the buttons */
    .btn1, .btn2, .btn3 {
        padding: 12px 24px;
    }
</style>

<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <!-- Slide 1 -->
    <div class="carousel-item active" data-bs-interval="3000">
      <img src="../uploads/slider/slide 1.jpg" class="d-block w-100" alt="Slide 1">
      <div class="carousel-caption d-flex justify-content-center align-items-center caption-slide-1">
        <a href="register.php" class="btn btn-primary btn0 btn1">Register Now</a>
        <a href="login.php" class="btn btn-primary btn0 btn1">Login Now</a>
      </div>
    </div>
    <!-- Slide 2 -->
    <div class="carousel-item" data-bs-interval="3000">
      <img src="../uploads/slider/slide 7.jpg" class="d-block w-100" alt="Slide 2">
      <div class="carousel-caption d-flex justify-content-center align-items-center caption-slide-2">
        <a href="register.php" class="btn btn-primary btn0 btn2">Register Now</a>
        <a href="login.php" class="btn btn-primary btn0 btn2">Login Now</a>
      </div>
    </div>
    <!-- Slide 3 -->
    <div class="carousel-item" data-bs-interval="3000">
      <img src="../uploads/slider/slide 6.jpg" class="d-block w-100" alt="Slide 3">
      <div class="carousel-caption d-flex justify-content-center align-items-center caption-slide-3">
        <a href="register.php" class="btn btn-primary btn0 btn3">Register Now</a>
        <a href="login.php" class="btn btn-primary btn0 btn3">Login Now</a>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Plans & Pricing Section -->
<div class="center-container mt-5">
    <div class="yellow-dot"></div>
</div>

<div class="col-md-9 mx-auto">
    <h2 class="product-title">---------- Plans & Pricing ----------</h2>
    <p class="product-description">Find a plan that suits your needs.</p>

    <div class="row text-center">
        <div class="row g-2">
            <!-- Basic Plan -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Basic</h3>
                        <p>
                            <span class="crossed-price">₹600</span>
                            <span class="display-5 text-primary">₹499</span>
                        </p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">3 Months</li>
                            <li class="list-group-item">25 Products</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Standard Plan -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-star fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Standard</h3>
                        <p>
                            <span class="crossed-price">₹1400</span>
                            <span class="display-5 text-primary">₹999</span>
                        </p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">7 Months</li>
                            <li class="list-group-item">60 Products</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Premium Plan -->
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-crown fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Premium</h3>
                        <p>
                            <span class="crossed-price">₹2400</span>
                            <span class="display-5 text-primary">₹1499</span>
                        </p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">12 Months</li>
                            <li class="list-group-item">100 Products</li>
                        </ul>
                    </div>
                </div>
            </div>
            <a href="faq.php" class="btn btn-primary btn4 mt-3">FAQ</a>
            <a href="subscription.php" class="btn btn-primary btn4 mt-3">More Info Plan</a>
        </div>
    </div>
</div>

<!-- Participants Section -->
<div class="center-container mt-5">
    <div class="yellow-dot"></div>
</div>

<?php
// Fetch total products
$totalProductsQuery = "SELECT COUNT(*) AS total FROM product";
$totalProductsResult = $conn->query($totalProductsQuery);
$total_product = $totalProductsResult->fetch_assoc()['total'];

// Fetch total vendors
$totalVendorsQuery = "SELECT COUNT(*) AS total FROM vendors";
$totalVendorsResult = $conn->query($totalVendorsQuery);
$total_vendors = $totalVendorsResult->fetch_assoc()['total'];

// Fetch total customers
$totalCustomersQuery = "SELECT COUNT(*) AS total FROM customer";
$totalCustomersResult = $conn->query($totalCustomersQuery);
$total_customers = $totalCustomersResult->fetch_assoc()['total'];
?>

<div class="col-md-9 mx-auto">
    <h2 class="product-title">---------- Our Participants ----------</h2>
    <div class="container card-container">
        <!-- Card 1 -->
        <div class="custom-card">
            <h3>
                <?php echo htmlspecialchars($total_customers); ?>
            </h3>
            <p>Total Customers</p>
        </div>

        <!-- Card 2 -->
        <div class="custom-card">
            <h3>
                <?php echo htmlspecialchars($total_vendors); ?>
            </h3>
            <p>Total Vendors</p>
        </div>

        <!-- Card 3 -->
        <div class="custom-card">
            <h3>
                <?php echo htmlspecialchars($total_product); ?>
            </h3>
            <p>Total Products</p>
        </div>
    </div>
</div>

<!-- Loader Animation -->
<div class="colorlib-loader">Loading...</div>

<!-- jQuery (for older browsers) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Loader Effect -->
<script>
    window.onload = function() {
        document.querySelector('.colorlib-loader').style.opacity = '0';
        setTimeout(function() {
            document.querySelector('.colorlib-loader').style.display = 'none';
        }, 500);
    };
</script>

<!-- Footer -->
<?php include "footer.php"; ?>
