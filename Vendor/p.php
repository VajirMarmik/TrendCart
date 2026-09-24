<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans & Pricing</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        h1 {
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            margin-top: 2rem;
            color: #0d6efd;
        }
        h2 {
            font-size: 1rem;
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px solid #0d6efd;
        }
        .btn-primary {
            border-radius: 25px;
        }
        .btn-primary:hover {
            background-color: #084298;
            transition: background-color 0.3s ease-in-out;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Plans & Pricing</h1>
        <h2>Find a plan that suits your needs</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-rocket fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Basic</h3>
                        <p>
                            <span class="crossed-price">₹600</span>
                            <span class="display-5 text-primary">₹499</span>
                        </p>
                        <p>Billed annually</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">3 Months</li>
                            <li class="list-group-item">25 Products</li>
                        </ul>
                        <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-star fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Standard</h3>
                        <p>
                            <span class="crossed-price">₹1400</span>
                            <span class="display-5 text-primary">₹999</span>
                        </p>
                        <p>Billed annually</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">7 Months</li>
                            <li class="list-group-item">60 Products</li>
                        </ul>
                        <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                    <i class="fas fa-crown fa-3x text-primary mb-3"></i>
                        <h3 class="card-title">Premium</h3>
                        <p>
                            <span class="crossed-price">₹2400</span>
                            <span class="display-5 text-primary">₹1499</span>
                        </p>
                        <p>Billed annually</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">12 Months</li>
                            <li class="list-group-item">100 Products</li>
                        </ul>
                        <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="faq-section mt-5">
            <h3 class="text-center">Get in touch</h3>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    When is my plan ready to use?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Your plan is ready as soon as payment is processed. Features such as dynamic QR codes are available immediately.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Can I upgrade to a higher plan later?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, you can upgrade anytime. Contact support for assistance.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Are there any cancellation fees?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No, you can cancel your plan anytime without incurring any cancellation fees.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Can I get a refund after cancellation?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Refunds are not available after cancellation. However, your plan will remain active until the end of the billing cycle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Do I get a discount for annual subscriptions?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, annual subscriptions are discounted compared to monthly payments.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Checkout -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Upload your document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="uploadFile" class="form-label">Choose File</label>
                            <input class="form-control" type="file" id="uploadFile">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
