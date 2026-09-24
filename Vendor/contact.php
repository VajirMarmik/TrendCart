<?php
include "db.php";
include "header.php";

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate input
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    // Initialize PHPMailer
    $mail = new PHPMailer(true);
    
    // Enable verbose debug output
    $mail->SMTPDebug = 0; // Set to 2 to see detailed debug output

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use your SMTP server details
        $mail->SMTPAuth = true;
        $mail->Username = 'trendcarts2024@gmail.com'; // Your Gmail address
        $mail->Password = 'woyy umkj bsgc qinq'; // Use your App Password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress('trendcarts2024@gmail.com', 'TrendCart'); // Recipient email and name

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Subject:</strong> $subject</p>
                       <p><strong>Message:</strong> $message</p>";

        // Send the email
        $mail->send();
        echo "<script>alert('Message has been sent successfully!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}
?>

<!-- Contact Us Section -->
<section id="contact-us" class="section container">
    <style>
        #contact-us a {
            text-decoration: none; /* Remove underline from links */
            color: inherit; /* Optional: inherit color from parent */
        }
        #contact-us a:hover {
            text-decoration: none; /* Optional: underline on hover */
            color: #f39c12; /* Change color on hover */
        }

        .btn {
            padding: 0.75rem;
            text-align: center;
            text-decoration: none;
            color: #f3f3f3;
            cursor: pointer;
            border-radius: 25px;
            margin: 0; /* Removes margin to make button full width */
            width: 35%; /* Ensures button takes full width of the grid column */
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12">
                <h2>Contact Information</h2>
                <div class="row contact-info-wrap">
                    <div class="col-md-3  mt-2">
                        <p><span><i class="fas fa-map-marker-alt"></i></span>&nbsp; 125, TrendCart Shop, Near Amroli, Surat-394107</p>
                    </div>
                    <div class="col-md-3  mt-2">
                        <p><span><i class="fas fa-phone"></i></span> <a href="tel://1234567920">&nbsp; +91 8866172158</a></p>
                    </div>
                    <div class="col-md-3  mt-2">
                        <p><span><i class="fas fa-envelope"></i></span> <a href="mailto:info@TrendCart.com">&nbsp; info@TrendCart.com</a></p>
                    </div>
                    <div class="col-md-3  mt-2">
                        <p><span><i class="fas fa-globe"></i></span> <a href="index.php">&nbsp; TrendCart.com</a></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="contact-wrap">
                    <h3>Get In Touch</h3>
                    <form action="contact.php" method="POST" class="contact-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="fullname">Full Name *</label>
                                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Your Full Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Your Email Address" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Your Subject" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="message">Message *</label>
                                    <textarea name="message" id="message" cols="15" rows="6" class="form-control" placeholder="Say something about us" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Send Message" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div id="map" class="colorlib-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3573.463273528018!2d72.85673817526258!3d21.242710880460663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjHCsDE0JzMzLjgiTiA3MsKwNTEnMzMuNSJF!5e1!3m2!1sen!2sin!4v1729408945602!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include "footer.php";
?>
