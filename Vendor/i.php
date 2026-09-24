<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fixed UPI ID QR Code</title>
</head>
<body>
    <?php
    // Include the database connection file
    include 'db.php';

    // Set a fixed UPI ID and fixed amount
    $upiId = "8866172158@mbk";
    $fixedAmount = "1.00"; // Change this to any amount you want

    // Create UPI link format with the fixed UPI ID and amount
    $upiLink = "upi://pay?pa={$upiId}&pn=PayeeName&am={$fixedAmount}&tn=PaymentNote";

    // Generate QR Code using the qrserver.com API with size 200x200
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($upiLink) . "&size=200x200";

    // Display the QR Code
    echo "<h1>Generated QR Code</h1>";
    echo "<p>Scan the QR Code below to make a payment:</p>";
    echo "<img src='{$qrCodeUrl}' alt='UPI QR Code'>";

    // Assuming payment success and receiving a UTR from the payment gateway
    $utrReceived = "UTR123456"; // This should be replaced by the actual UTR received from the payment response

    // Check if the UTR already exists in the database
    $vendor_id = 1; // Replace with the actual vendor ID
    $stmt = $conn->prepare("SELECT utr_no FROM vendors WHERE id = ? AND utr_no = ?");
    $stmt->bind_param("is", $vendor_id, $utrReceived);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p>This payment has already been recorded. No update needed.</p>";
    } else {
        // Update the subscription amount and store the UTR
        $stmt->close();

        $sql = "UPDATE vendors SET subscribe = subscribe + ?, utr_no = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dsi", $fixedAmount, $utrReceived, $vendor_id);

        if ($stmt->execute()) {
            echo "<p>Subscription amount updated successfully in the database.</p>";
        } else {
            echo "<p>Error updating subscription amount: " . $stmt->error . "</p>";
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
