<?php
session_start();
include 'db.php';
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header('Location: login.php');
    exit();
}
$msg = "";
if (isset($_POST['submit'])) {
    $customer_id = $_SESSION['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO feedback (customer_id, name, email, message) VALUES ('$customer_id', '$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $msg = "<div class='alert alert-success'>Thank you for your feedback!</div>";
        } else {
            $msg = "<div class='alert alert-danger'>There was an error submitting your feedback. Please try again.</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please fill out all fields.</div>";
    }
}
?>
<?php include 'header.php'; ?>

<style>
        .btn {
            padding: 0.75rem;
            text-align: center;
            text-decoration: none;
            color: #f3f3f3;
            cursor: pointer;
            border-radius: 25px;
            margin: 0; /* Removes margin to make button full width */
            width: 20%; /* Ensures button takes full width of the grid column */
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
<section id="feedback" class="section container">
    <div class="container mt-5">
        <h2>Share Your Feedback</h2>
        <?php echo $msg; ?>
        <form action="feedback.php" method="POST">
            <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail *</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="form-group">
                <label for="message">Feedback *</label>
                <textarea class="form-control" id="message" name="message" rows="5"  placeholder="Share Your Feedback" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
</section>
<?php include "footer.php"; ?>
