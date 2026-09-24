<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SR. No</th>
                <th>Vendor</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Size</th>
                <th>Color</th>
                <th>Type</th>
                <th>Description</th>
                <th>Price</th>
                <th>Created At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $sr_no = $startFrom + 1; // Start numbering from $startFrom + 1 ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $sr_no++; ?></td>
                        <td><?php echo $row['vendor_name']; ?></td>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['brand_name']; ?></td>
                        <td>
                            <?php if (!empty($row['photo_path'])): ?>
                                <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="Product Image" width="100%" height="auto" 
                                     onclick="openImageModal('<?php echo htmlspecialchars($row['photo_path']); ?>', '<?php echo htmlspecialchars($row['product_name']); ?>')" style="cursor:pointer;">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td><?php echo ucfirst(str_replace('_', ' ', $row['status'])); ?></td>
                        <td>
                            <?php if ($row['status'] == 'pending'): ?>
                                <button type="button" class="btn btn-success btn-sm verify-btn" data-id="<?php echo $row['product_id']; ?>" style="position: relative;">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="tooltip-text">Verify</span>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm not-verify-btn" data-id="<?php echo $row['product_id']; ?>" style="position: relative;">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                    <span class="tooltip-text">Not Verify</span>
                                </button>
                            <?php else: ?>
                                <span class="text-muted">No actions available</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" class="text-center">No records found</td>
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
                <h5 id="modalProductName" class="modal-product-name"></h5>
                <img id="modalImage" src="" alt="Product Image" class="img-fluid img1" />
            </div>
        </div>
    </div>
</div>

<script>
    function openImageModal(imageUrl, productName) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalProductName').innerText = productName;
        var modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>

<style>
    .modal-product-name {
        font-weight: bold;
        margin-bottom: 15px;
    }

    .modal-product-name:hover {
        font-weight: bold;
        margin-bottom: 20px;
    }
</style>