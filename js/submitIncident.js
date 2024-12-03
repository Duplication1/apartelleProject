$(document).on('click', '#submitButton', function() {
    var formData = new FormData($('#incidentReportForm')[0]);

    $.ajax({
        type: 'POST',
        url: 'securityAndSafety/submit_incident.php', // Ensure this path is correct
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response); // Log the response for debugging
            $('#responseMessage').html('<div class="alert alert-success">Incident reported successfully!</div>');
            $('#incidentReportForm')[0].reset(); // Reset the form
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error); // Log error for debugging
            $('#responseMessage').html('<div class="alert alert-danger">Error reporting incident: ' + error + '</div>');
        }
    });
});

$(document).ready(function() {
    $('#submitButton').on('click', function() {
        var formData = new FormData($('#incidentReportForm')[0]);

        $.ajax({
            type: 'POST',
            url: 'securityAndSafety/submit_incident.php', // Path to your PHP script
            data: formData,
            processData: false, 
            contentType: false,
            success: function(response) {
                $('#responseMessage').html('<div class="alert alert-success">Incident reported successfully!</div>');
                $('#incidentReportForm')[0].reset(); // Reset the form
                location.reload(); // Reload the page to show the updated list
            },
            error: function(xhr, status, error) {
                $('#responseMessage').html('<div class="alert alert-danger">Error reporting incident: ' + error + '</div>');
            }
        });
    });

    // Update status on change
    $(document).on('change', '.status-select', function() {
        var status = $(this).val();
        var id = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'securityAndSafety/update_status.php', // Path to your PHP script to update the status
            data: { id: id, status: status },
            success: function(response) {
                $('#responseMessage').html('<div class="alert alert-success">Status updated successfully!</div>');
            },
            error: function(xhr, status, error) {
                $('#responseMessage').html('<div class="alert alert-danger">Error updating status: ' + error + '</div>');
            }
        });
    });
});