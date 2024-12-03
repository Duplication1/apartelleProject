$(document).on('click', '#addItemButton', function() {
    var newItem = $('.order-item:first').clone(); // Clone the first item row
    newItem.find('input').val(''); // Reset values
    $('.order-items').append(newItem); // Append the new item row
});

// Remove an item input field
$(document).on('click', '.remove-item', function() {
    $(this).closest('.order-item').remove(); // Remove the current item row
});
$(document).on('click', '#submitButtonOrder', function() {
var formData = new FormData($('#orderReportForm')[0]);
var submitButton = $(this);

// Disable the button to prevent multiple submissions
submitButton.prop('disabled', true);

$.ajax({
    type: 'POST',
    url: 'inventoryManagement/submit_order.php',
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        console.log(response);
        $('#responseMessage').html('<div class="alert alert-success">Order reported successfully!</div>');
        $('#orderReportForm')[0].reset();
    },
    error: function(xhr, status, error) {
        console.error("AJAX Error:", error);
        $('#responseMessage').html('<div class="alert alert-danger">Error reporting order: ' + error + '</div>');
    },
    complete: function() {
        // Re-enable the button after request completes
        submitButton.prop('disabled', false);
    }
});
});