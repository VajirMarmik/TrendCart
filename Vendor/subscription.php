<?php
include "db.php";
// session_start(); // Start the session for user tracking
include "header.php";
?>

    <!-- <style>
        .table-container {
            margin: 20px auto;
            max-width: 90%;
            text-align: center;
        }

        .table th {
            background-color: #001F5B;
            color: white;
            text-transform: uppercase;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .title {
            text-align: center;
            font-size: 1.8rem;
            margin: 20px 0;
        }
    </style> -->
    <style>
    .table-container {
        margin: 20px auto;
        max-width: 90%;
        text-align: center;
    }

    .table th {
        background-color:rgb(27, 27, 28);
        color: white; /* White text for the header */
        text-transform: uppercase;
    }

    .table td,
    .table th {
        vertical-align: middle;
        color: white; /* White text for table content */
        border: 1px solid #ffffff; /* Optional: adds white border around cells */
    }

    /* Odd Rows */
    .table tbody tr:nth-child(odd) td {
        background-color:rgb(62, 66, 70); /* Slightly lighter blue for even rows */
    }

    /* Even Rows */
    .table tbody tr:nth-child(even) td {
        background-color:rgb(37, 40, 43); /* Darker blue for odd rows */
    }

    .title {
        text-align: center;
        font-size: 1.8rem;
        margin: 20px 0;
    }

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


    <!-- Subscription Plan Section -->
    <section id="subscription" class="section container">
        <div class="table-container mt-5">
            <h3 class="title">Registration Subscription Plan</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subscription Plan</th>
                        <th>Free</th>
                        <th>Basic</th>
                        <th>Standard</th>
                        <th>Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Registration Approval Duration</td>
                        <td>48 HOURS</td>
                        <td>48 HOURS</td>
                        <td>48 HOURS</td>
                        <td>48 HOURS</td>
                    </tr>
                    <tr>
                        <td>Access Duration</td>
                        <td>7 DAYS</td>
                        <td>3 MONTHS</td>
                        <td>7 MONTHS</td>
                        <td>1 YEAR</td>
                    </tr>
                    <tr>
                        <td>Products Add Limit</td>
                        <td>5 PRODUCTS</td>
                        <td>25 PRODUCTS</td>
                        <td>60 PRODUCTS</td>
                        <td>100 PRODUCTS</td>
                    </tr>
                    <tr>
                        <td>Products Approval TIme</td>
                        <td>24 HOURS</td>
                        <td>24 HOURS</td>
                        <td>24 HOURS</td>
                        <td>24 HOURS</td>
                    </tr>
                    <tr>
                        <td>Products ADS Cost</td>
                        <td>FREE</td>
                        <td>FREE</td>
                        <td>FREE</td>
                        <td>FREE</td>
                    </tr>
                    <tr>
                        <td>Payment Receive Type</td>
                        <td>UPI ID</td>
                        <td>UPI ID</td>
                        <td>UPI ID</td>
                        <td>UPI ID</td>
                    </tr>
                    <tr>
                        <td>Payment Receive Time</td>
                        <td>IMMEDIATELY</td>
                        <td>IMMEDIATELY</td>
                        <td>IMMEDIATELY</td>
                        <td>IMMEDIATELY</td>
                    </tr>
                    <tr>
                        <td>Total Pay Amount</td>
                        <td>₹ 0/-</td>
                        <td>₹ 499/-</td>
                        <td>₹ 999/-</td>
                        <td>₹ 1499/-</td>
                    </tr>
                </tbody>
            </table>
            <a href="register.php" class="btn btn-primary">Register Now</a>
        </div>
    </section>

<?php
include "footer.php";
?>
