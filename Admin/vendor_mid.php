<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>SR. No</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Profile Photo</th>
                <th>Email</th>
                <th>Phone</th>
                <th>PAN Card Number</th>
                <th>PAN Card Front</th>
                <th>PAN Card Back</th>
                <th>Subscription Plan</th>
                <th>Payment Screenshort</th>
                <th>Created At</th>
                <th>E-Mail Send Status</th>
                <th>E-mail Receive Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <?php
            // Define the path to the uploads directory
            $upload_path = "../uploads/"; // Path to the uploads directory
        ?>
    
        <tbody>
            <?php
                // Loop through all vendor records and display them
                if ($result->num_rows > 0) { 
                    $sr_no = $startFrom + 1; // Start numbering from $startFrom + 1
                    while ($user = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $sr_no++ . "</td>";  // Display the serial number and increment it
                        echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td><img src='" . $upload_path . htmlspecialchars($user['photo']) . "' alt='Profile Photo' style='width: 100px; height: auto;' onclick='openModal(\"" . $upload_path . htmlspecialchars($user['photo']) . "\")'></td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['pancard_number']) . "</td>";
                        echo "<td><img src='" . $upload_path . htmlspecialchars($user['pancard_front']) . "' alt='PAN Card Front' style='width: 100px; height: auto;' onclick='openModal(\"" . $upload_path . htmlspecialchars($user['pancard_front']) . "\")'></td>";
                        echo "<td><img src='" . $upload_path . htmlspecialchars($user['pancard_back']) . "' alt='PAN Card Back' style='width: 100px; height: auto;' onclick='openModal(\"" . $upload_path . htmlspecialchars($user['pancard_back']) . "\")'></td>";
                        echo "<td>" . htmlspecialchars($user['make_plan']) . "</td>";
                        echo "<td><img src='" . $upload_path . htmlspecialchars($user['payment_photo']) . "' alt='Payment Screenshot' style='width: 100px; height: auto;' onclick='openModal(\"" . $upload_path . htmlspecialchars($user['payment_photo']) . "\")'></td>";
                        echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['verification_status']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['is_verified']) . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='vendor_id' value='" . $user['id'] . "'>";
                        if ($user['verification_status'] === 'Not Verified') {
                            echo "<input type='hidden' name='verification_status' value='Verified'>";
                            echo "<button type='submit' name='verify_vendor' class='verify-btn'>Verify</button>";
                        } else {
                            echo "No Action Available";
                        }
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }    
                } else {
                    echo "<tr><td colspan='13' class='text-center'>No Vendors found for selected date range</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>
