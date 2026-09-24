<?php

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

?>


            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.verify-btn').on('click', function() {
            var button = $(this);
            var productId = button.data('id');
            button.prop('disabled', true);
            button.siblings('.btn').prop('disabled', true);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to verify this product?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'update_product_status.php',
                        type: 'POST',
                        data: { productId: productId, status: 'verified' },
                        success: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Product has been verified successfully.',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to verify product: ' + xhr.responseText,
                                'error'
                            );
                            button.prop('disabled', false);
                            button.siblings('.btn').prop('disabled', false);
                        }
                    });
                } else {
                    button.prop('disabled', false);
                    button.siblings('.btn').prop('disabled', false);
                }
            });
        });

        $('.not-verify-btn').on('click', function() {
            var button = $(this);
            var productId = button.data('id');
            button.prop('disabled', true);
            button.siblings('.btn').prop('disabled', true);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to mark this product as not verified?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, mark it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'update_product_status.php',
                        type: 'POST',
                        data: { productId: productId, status: 'not_verified' },
                        success: function(response) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Product has been marked as not verified.',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'Failed to update product status: ' + xhr.responseText,
                                'error'
                            );
                            button.prop('disabled', false);
                            button.siblings('.btn').prop('disabled', false);
                        }
                    });
                } else {
                    button.prop('disabled', false);
                    button.siblings('.btn').prop('disabled', false);
                }
            });
        });
    });

    // Function to validate the dates
    function validateDates() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate > endDate && startDate && endDate) {
            // Show SweetAlert if start date is greater than end date
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Start date cannot be greater than end date!',
                confirmButtonText: 'OK'
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
</body>
</html>
