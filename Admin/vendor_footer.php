

        </div>
    </div>
</div>

<!-- Modal to display full-size image -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full Size Image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openModal(imageSrc) {
        // Set the source of the image in the modal
        document.getElementById('modalImage').src = imageSrc;
        // Show the modal
        var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }

    document.getElementById('reportForm').onsubmit = function () {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        if (startDate > endDate && startDate && endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Start date cannot be greater than end date!'
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    };
</script>
</body>
</html>