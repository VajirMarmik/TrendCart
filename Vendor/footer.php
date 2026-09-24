<footer class="footer bg-dark text-light py-4" style="margin-top: 50px;">
    <div class="container mb-3">
        <style>
            /* Remove default list styling */
            .colorlib-footer-links {
                list-style: none; /* No bullets */
                padding: 0; /* Remove padding */
                margin: 0; /* Remove margin */
            }

            .colorlib-footer-links li {
                margin-bottom: 10px; /* Space between items */
            }

            .colorlib-footer-links a {
                text-decoration: none; /* No underline on links */
                color: #ffffff; /* Link color */
                transition: color 0.3s; /* Transition effect */
            }

            .colorlib-footer-links a:hover {
                text-decoration: none;
                color: #f39c12; /* Change color on hover */
            }

            .social-icons a {
                color: #ffffff; /* Icon color */
                margin: 0 10px; /* Margin between icons */
                transition: color 0.3s; /* Transition effect */
            }

            .social-icons a:hover {
                color: #f39c12; /* Change color on hover */
            }

            .footer-col h4 {
                border-bottom: 1px solid #f39c12; /* Underline for headings */
                padding-bottom: 10px; /* Space below the heading */
                margin-bottom: 15px; /* Space below the heading */
            }

            .footer-col {
                padding: 15px; /* Padding for each footer column */
            }

            @media (max-width: 768px) {
                .footer-col {
                    margin-bottom: 20px; /* Space between columns on small screens */
                }
            }
        </style>

        <div class="row row-pb-md">
            <div class="col footer-col colorlib-widget">
                <h4>About TrendCart</h4>
                <p style="text-align: justify;">TrendCart is a Surat-based footwear platform offering a subscription model that empowers sellers to grow their business with zero commissions, free promotions, and a flexible product management process.</p>
                <div class="social-icons">
                    <a href="#" class="mx-2"><i class="bx bxl-facebook"></i></a>
                    <a href="#" class="mx-2"><i class="bx bxl-twitter"></i></a>
                    <a href="#" class="mx-2"><i class="bx bxl-instagram"></i></a>
                </div>
            </div>
            <div class="col footer-col colorlib-widget">
                <h4>Vendor Services</h4>
                <ul class="colorlib-footer-links">
                    <li><a href="subscription.php">Subscription Plan</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="col footer-col">
                <h4>Contact Information</h4>
                <ul class="colorlib-footer-links">
                    <li><a href="tel://1234567920"><i class="bx bxs-phone">&nbsp; +91 8866172158</i></a></li>
                    <li><a href="index.php"><i class="bx bx-globe">&nbsp; www.TrendCart.com</i></a></li>
                    <li><a href="mailto:info@trendcart.com"><i class="bx bxs-envelope">&nbsp; info@trendcart.com</i></a></li>
                    <li><a href="contact.php"><i class="bx bxs-map">&nbsp; Site maps</i></a></li>
                    <li>125, TrendCart Shop, Near Amroli, Surat-394107</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copy">
        <div class="row">
            <div class="col-sm-12 text-center">
                <p>
                    &copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    TrendCart. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<script>
    const themeIcon = document.getElementById('themeIcon');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-theme');
        themeIcon.classList.remove('bx-moon');
        themeIcon.classList.add('bx-sun');
    }

    themeIcon.addEventListener('click', () => {
        body.classList.toggle('dark-theme');
        if (body.classList.contains('dark-theme')) {
            themeIcon.classList.remove('bx-moon');
            themeIcon.classList.add('bx-sun');
            localStorage.setItem('theme', 'dark');
        } else {
            themeIcon.classList.remove('bx-sun');
            themeIcon.classList.add('bx-moon');
            localStorage.setItem('theme', 'light');
        }
    });
</script>
