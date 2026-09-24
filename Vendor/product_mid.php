<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SR. No</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php  $sr_no = $startFrom + 1; ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $sr_no++; ?></td>
                            <td>
                                <?php if(!empty($row['photo_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="Product Image" width="100%" height="auto" 
                                        onclick="openImageModal('<?php echo htmlspecialchars($row['photo_path']); ?>', '<?php echo htmlspecialchars($row['product_name']); ?>')" style="cursor:pointer;">
                                <?php else: ?>
                                    No image
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['size']); ?></td>
                            <td><?php echo htmlspecialchars($row['color']); ?></td>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <?php
                                    $status = htmlspecialchars($row['status']);
                                    echo $status === 'verified' ? '<span class="badge bg-success">Verified</span>' : 
                                        ($status === 'not_verified' ? '<span class="badge bg-danger">Not Verified</span>' : 
                                        '<span class="badge bg-warning">Pending</span>');
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#updateProductModal"
                                    data-id="<?php echo htmlspecialchars($row['product_id']); ?>"
                                    data-size="<?php echo htmlspecialchars($row['size']); ?>"
                                    data-color="<?php echo htmlspecialchars($row['color']); ?>"
                                    data-type="<?php echo htmlspecialchars($row['type']); ?>"
                                    data-name="<?php echo htmlspecialchars($row['product_name']); ?>"
                                    data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                    data-price="<?php echo htmlspecialchars($row['price']); ?>"
                                    data-category-id="<?php echo htmlspecialchars($row['category_id']); ?>"
                                    data-brand-id="<?php echo htmlspecialchars($row['brand_id']); ?>">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    <span class="tooltip-text">Update Product</span>
                                </button>

                                <button type="button" class="btn btn-danger btn-sm btn-icon delete-btn" data-id="<?php echo htmlspecialchars($row['product_id']); ?>">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    <span class="tooltip-text">Delete Product</span>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="13" class="text-center">No products found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap Modal for Zooming Image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <h5 id="modalProductName" class="modal-product-name"></h5> <!-- Product Name Display -->
        <img id="modalImage" src="" alt="Product Image" class="img-fluid img1" />
      </div>
    </div>
  </div>
</div>

<script>
    function openImageModal(imageUrl, productName) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalProductName').innerText = productName; // Set the product name
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>

<style>
    .modal-product-name {
        font-weight: bold; /* Makes the text bold */
        margin-bottom: 15px; /* Adjust the value as needed for spacing */
    }

    .modal-product-name:hover {
        font-weight: bold; /* Makes the text bold */
        margin-bottom: 20px; /* Adjust the value as needed for spacing */
    }

</style>

