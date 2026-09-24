<?php
// Include your header if you have a separate header file
include "header.php";
?>

<!-- Custom CSS -->
<style>
    /* Carousel styling */
    .carousel {
        height: 80%; /* Set a fixed height for the carousel */
    }

    .carousel-item img {
        width: 100%;
        height: 100%; /* Make sure images fill the carousel height */
        aspect-ratio: 4/4;
        object-fit: contain;
    }

    /* Overlay on images */
    .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6); /* Semi-transparent overlay */
        z-index: 1;
    }

    /* Slogan on the carousel */
    .slogan {
        position: absolute;
        z-index: 2;
        top: -100px; /* Initially off-screen */
        right: 0;
        text-align: left;
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
        opacity: 0; /* Initially hidden */
        animation: jumpIn 5s ease forwards; /* Animation timing set to 10 seconds */
    }

    @keyframes jumpIn {
        0% {
            top: -100px; /* Start off-screen */
            opacity: 0;
        }
        60% {
            top: 20px; /* Overshoot */
            opacity: 1;
        }
        80% {
            top: 0px; /* Bounce down */
        }
        100% {
            top: 10%; /* Final resting position */
        }
    }
    /* Loader animation */
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

    /* Card animation */
    .card {
        overflow: hidden; /* Hide overflow for the animation */
        position: relative; /* For absolute positioning of the text */
    }

    .card-body {
        position: absolute; /* Position text absolutely */
        bottom: -100%; /* Start off the screen */
        left: 0;
        width: 100%;
        transition: bottom 0.3s ease; /* Transition for the bottom property */
        color: white;
        background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background for better visibility */
        padding: 10px; /* Padding for the text */
    }

    .card:hover .card-body {
        bottom: 0; /* Move text into view on hover */
    }

    /* Custom styles */
    .product-title {
        text-align: center;
        margin: 20px 0; /* Space around the title */
        font-size: 2rem;
        font-weight: bold;
    }

    .product-description {
        text-align: center;
        font-size: 1rem;
    }

    .custom-card-margin {
        margin-bottom: 20px; /* Space between cards */
    }

    /* Button styles */
    .btn-success-hover:hover {
        background-color: #28a745; /* Success color on hover */
        color: white; /* Text color */
    }
    
    /* Remove underline from anchor tags */
    .card a {
        text-decoration: none; /* Remove underline */
        color: #fff;
    }

    /* Custom container for the logos */
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

    /* Style for each logo item */
    .logo-item {
        padding: 20px;
        border-radius: 10px;
        background-color: transparent; /* Set to transparent to remove the background */
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

    /* Container to center the dot */
    .center-container {
    display: flex;
    justify-content: center; /* Centers horizontally */
    align-items: center;     /* Centers vertically */
    }

    /* Yellow dot style */
    .yellow-dot {
    width: 15px;
    height: 15px;
    background-color: yellow;
    border-radius: 50%;
    }

    .btn {
                padding: 0.75rem;
                text-align: center;
                text-decoration: none;
                color: #f3f3f3;
                cursor: pointer;
                border-radius: 25px;
                margin: 0; /* Removes margin to make button full width */
                width: 30%; /* Ensures button takes full width of the grid column */
                align-item: center;
                transition: all 250ms ease-in-out;
            }

            .btn:hover {
                box-shadow: 0 0 0 1.5px #fff, 0 0 0 3px #0000ff;
                background-color: #11ce1b;
                color: black;
                font-size: 20px;
            }
</style>


<!-- Carousel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <!-- Carousel indicators -->
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < 3; $i++): ?>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
        <?php endfor; ?>
    </div>

    <div class="carousel-inner">
        <?php
        // SQL query to fetch the latest 3 products for the carousel
        $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name 
                FROM product p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.status = 'verified'
                ORDER BY p.created_at DESC LIMIT 3";  // Fetch only the latest 3 products

        $result = $conn->query($sql);

        if (!$result) {
            die("Error fetching products: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $first = true;
            $slogans = [
                "Stride in Style with TrendCart Footwear",
                "Experience Comfort Like Never Before",
                "Step Into Your New Style Today"
            ];

            $index = 0; // Initialize the index for slogans

            while ($row = $result->fetch_assoc()) {
                $imagePath = $row['photo_path']; 

                if (file_exists($imagePath)) {
                    $imageSrc = $imagePath;
                } else {
                    $imageSrc = 'images/default_product.jpg'; 
                }
                ?>
                <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                    <img src="<?php echo $imageSrc; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
                    <div class="slogan"><?php echo htmlspecialchars($slogans[$index]); ?></div> <!-- Displaying specific slogans -->
                </div>
                <?php
                $first = false; // After the first iteration, set it to false
                $index++; // Increment the slogan index
            }
        } else {
            echo "<p class='text-center'>No products found for the carousel.</p>";
        }
        ?>
    </div>
</div>

<div class="center-container mt-5">
    <div class="yellow-dot"></div>
</div>

<div class="col-md-9 mx-auto"> <!-- Center align the right side (75%) -->
    <h2 class="product-title">---------- Find Your Footwear ----------</h2> <!-- Title for the product section -->
    <p class="product-description">Step into the essence of pure, vibrant styles as you explore our premium footwear collection.</p>
    <div class="row text-center"> <!-- Center the text -->
        <?php
        // SQL query to fetch products sorted by created_at in descending order
        $sql = "SELECT p.*, c.name AS category_name, b.name AS brand_name 
                FROM product p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.status = 'verified'
                ORDER BY p.created_at DESC LIMIT 6";  // Fetch only 3 products

        $result = $conn->query($sql);

        if (!$result) {
            die("Error fetching products: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $imagePath = $row['photo_path']; 

                if (file_exists($imagePath)) {
                    $imageSrc = $imagePath;
                } else {
                    $imageSrc = 'images/default_product.jpg'; 
                }
                ?>
                <div class="col-md-4 custom-card-margin mt-3"> <!-- 3 products per row -->
                    <div class="card">
                        <img class="img card-img-top" src="<?php echo $imageSrc; ?>" alt="<?php echo $row['product_name']; ?>" style="height: 200px; object-fit: contain;">
                        <div class="card-body">
                            <a href="product_details.php?id=<?php echo $row['product_id']; ?>"><h5 class="card-title text-center"><?php echo $row['product_name'] ?></h5> </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No products found.</p>";
        }
        ?>
    </div>
    <div class="text-center"> <!-- Center align the button -->
        <a href="product.php" class="btn btn-primary fs-5 mb-5 mt-3">View More Products </a> <!-- Button to link to product.php -->
    </div>
</div>

<div class="center-container">
    <div class="yellow-dot"></div>
</div>

<div class="col-md-9 mx-auto">
    <h2 class="product-title">---------- Our Best Partners ----------</h2>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="logo-item">
                <img src="logo-1.png" alt="PUMA Logo">
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="logo-item">
                <img src="logo-2.png" alt="NIKE Logo">
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="logo-item">
                <img src="logo-3.png" alt="adidas Logo">
            </div>
        </div>
    </div>
</div>


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

<script>
    var carouselElement = document.getElementById('carouselExampleCaptions');

    // Listen for carousel sliding event
    carouselElement.addEventListener('slide.bs.carousel', function(event) {
        // Select the active slogan element
        var activeSlogan = document.querySelector('.carousel-item.active .slogan');

        if (activeSlogan) {
            // Remove the animation class to restart the animation
            activeSlogan.style.animation = 'none';
            activeSlogan.offsetHeight; // Trigger a reflow, flushing the CSS changes

            // Reapply the animation
            activeSlogan.style.animation = 'jumpIn 5s ease forwards';
        }
    });
</script>
