<?php
// Check if a success message is set
if (isset($_SESSION['success_message'])) {
    echo '<div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
            <div id="successMessage" class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>
          </div>';
    unset($_SESSION['success_message']);
}

// Check if an error message is set
if (isset($_SESSION['error_message'])) {
    echo '<div class="position-fixed top-0 end-0 p-3" style="z-index: 5">
            <div id="errorMessage" class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>
          </div>';
    unset($_SESSION['error_message']);
}
?>

<script>
    // Auto-dismiss the success message after 4 seconds
    setTimeout(function() {
        var successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.opacity = 0;
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 1000); // Fade out duration
        }
    }, 4000);

    // Auto-dismiss the error message after 4 seconds
    setTimeout(function() {
        var errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            errorMessage.style.opacity = 0;
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 1000); // Fade out duration
        }
    }, 4000);
</script>