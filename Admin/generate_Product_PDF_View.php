<?php

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

// Check if any products are fetched
if ($result->num_rows > 0) {
    $html .= '<table border="1" cellpadding="4">';
    $html .= '<thead>
                <tr>
                    <th width="4%"><b>SR. No</b></th>
                    <th width="7%"><b>Vendor</b></th>
                    <th width="8%"><b>Category</b></th>
                    <th width="7%"><b>Brand</b></th>
                    <th width="8%"><b>Product Image</b></th>
                    <th width="8%"><b>Product Name</b></th>
                    <th width="5%"><b>Size</b></th>
                    <th width="6%"><b>Color</b></th>
                    <th width="7%"><b>Type</b></th>
                    <th width="16%"><b>Description</b></th>
                    <th width="7%"><b>Price</b></th>
                    <th width="10%"><b>Created At</b></th>
                    <th width="7%"><b>Status</b></th>
                </tr>
              </thead>
              <tbody>';

    $serialNumber = 1;
    while ($row = $result->fetch_assoc()) {
        $photoPath = htmlspecialchars($row['photo_path']);
        $imgSrc = !empty($photoPath) && file_exists($photoPath) ? $photoPath : 'path/to/placeholder_image.jpg';
        $imgAlt = !empty($photoPath) && file_exists($photoPath) ? 'Product Image' : 'Image Not Available';

        $html .= '<tr>
                    <td width="4%">' . $serialNumber++ . '</td>
                    <td width="7%">' . htmlspecialchars($row['vendor_name']) . '</td>
                    <td width="8%">' . htmlspecialchars($row['category_name']) . '</td>
                    <td width="7%">' . htmlspecialchars($row['brand_name']) . '</td>
                    <td width="8%"><img src="' . $imgSrc . '" alt="' . $imgAlt . '" width="100" height="auto"></td>
                    <td width="8%">' . htmlspecialchars($row['product_name']) . '</td>
                    <td width="5%">' . htmlspecialchars($row['size']) . '</td>
                    <td width="6%">' . htmlspecialchars($row['color']) . '</td>
                    <td width="7%">' . htmlspecialchars($row['type']) . '</td>
                    <td width="16%">' . htmlspecialchars($row['description']) . '</td>
                    <td width="7%">' . htmlspecialchars($row['price']) . '</td>
                    <td width="10%">' . htmlspecialchars($row['created_at']) . '</td>
                    <td width="7%">' . ucfirst(str_replace('_', ' ', htmlspecialchars($row['status']))) . '</td>
                  </tr>';        
    }

    $html .= '</tbody></table>';
} else {
    $html .= '<p>No products found.</p>';
}

?>
