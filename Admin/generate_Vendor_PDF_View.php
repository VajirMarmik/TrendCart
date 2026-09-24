<?php

if ($result->num_rows > 0) {
    $html .= '<table border="1" cellpadding="4">
                <tr>
                    <th width="4%"><b>SR. No</b></th>
                    <th width="6%"><b>Full Name</b></th>
                    <th width="5%"><b>Username</b></th>
                    <th width="8%"><b>Profile Photo</b></th>
                    <th width="7%"><b>Email</b></th>
                    <th width="7%"><b>Phone</b></th>
                    <th width="8%"><b>PAN Number</b></th>
                    <th width="7%"><b>PAN Front</b></th>
                    <th width="7%"><b>PAN Back</b></th>
                    <th width="8%"><b>Subscription Plan</b></th>
                    <th width="10%"><b>Payment Screenshort</b></th>
                    <th width="10%"><b>Created At</b></th>
                    <th width="7%"><b>Send Status</b></th>
                    <th width="6%"><b>Receive Status</b></th>
                </tr>';

    $serialNumber = 1;
    while ($user = mysqli_fetch_assoc($result)) {
        $html .= '<tr>
                    <td width="4%">' . $serialNumber++ . '</td>
                    <td width="6%">' . htmlspecialchars($user['full_name']) . '</td>
                    <td width="5%">' . htmlspecialchars($user['username']) . '</td>
                    <td width="8%"><img src="../uploads/' . htmlspecialchars($user['photo']) . '" style="width: 50px; height: auto;"></td>
                    <td width="7%">' . htmlspecialchars($user['email']) . '</td>
                    <td width="7%">' . htmlspecialchars($user['phone']) . '</td>
                    <td width="8%">' . htmlspecialchars($user['pancard_number']) . '</td>
                    <td width="7%"><img src="../uploads/' . htmlspecialchars($user['pancard_front']) . '" style="width: 50px; height: auto;"></td>
                    <td width="7%"><img src="../uploads/' . htmlspecialchars($user['pancard_back']) . '" style="width: 50px; height: auto;"></td>
                    <td width="8%">' . htmlspecialchars($user['make_plan']) . '</td>
                    <td width="10%"><img src="../uploads/' . htmlspecialchars($user['payment_photo']) . '" style="width: 50px; height: auto;"></td>
                    <td width="10%">' . htmlspecialchars($user['created_at']) . '</td>
                    <td width="7%">' . htmlspecialchars($user['verification_status']) . '</td>
                    <td width="6%">' . htmlspecialchars($user['is_verified']) . '</td>
                  </tr>';
    }
        
    $html .= '</tbody></table>';
} else {
    $html .= '<p>No vendors found.</p>';
}

?>
