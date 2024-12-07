$(document).ready(function() {
    // Handle individual status update (maintenance tasks)
    $(document).on('click', '.btn-update-maintenance', function() {
        var status = $(this).closest('tr').find('.status-dropdown').val();
        var taskId = $(this).data('id');  // Fetch maintenance schedule ID

        // Make sure the status is selected
        if (!status) {
            showSnackbar('Please select a status.', false);  // Show error Snackbar
            return;
        }

        $.ajax({
            url: 'housekeepingAndMaintenance/update_maintenance_schedule.php',
            method: 'POST',
            data: {
                id: taskId,    // Maintenance task ID to update
                status: status // New status to set
            },
            success: function(response) {
                var responseData = JSON.parse(response);  // Parse the JSON response

                if (responseData.success) {
                    showSnackbar('Status updated successfully!', true);  // Show success Snackbar
                    setTimeout(function() {
                        location.reload();  // Reload the page after 2 seconds
                    }, 2000); // Reload the page to show the updated status
                } else {
                    showSnackbar('Error: ' + responseData.error, false);  // Show error Snackbar
                }
            },
            error: function(xhr, status, error) {
                showSnackbar('Error: ' + error, false);  // Show error Snackbar
            }
        });
    });

    // Handle update all maintenance dates
    $('#btn-update-all-maintenance').on('click', function() {
        var newDate = $('#updateDateInputMaintenance').val();  // Get the new date from the input

        if (!newDate) {
            showSnackbar('Please select a date before updating all tasks.', false);  // Show error Snackbar
            return;
        }

        $.ajax({
            url: 'housekeepingAndMaintenance/update_maintenance_schedule.php',  // PHP backend to handle bulk date update for maintenance tasks
            method: 'POST',
            data: {
                newDate: newDate  // New date for updating all maintenance schedules
            },
            success: function(response) {
                var responseData = JSON.parse(response);  // Parse the JSON response

                if (responseData.success) {
                    showSnackbar('All maintenance dates updated successfully!', true);  // Show success Snackbar
                    setTimeout(function() {
                        location.reload();  // Reload the page after 2 seconds
                    }, 2000);  // Reload the page to reflect the changes
                } else {
                    showSnackbar('Error: ' + responseData.error, false);  // Show error Snackbar
                }
            },
            error: function(xhr, status, error) {
                showSnackbar('Error: ' + error, false);  // Show error Snackbar
            }
        });
    });

    // Handle assignee update for maintenance tasks
    $(document).on('click', '.btn-update-maintenance', function() {
        var scheduleId = $(this).data('id');
        var assigneeId = $(this).closest('tr').find('.assignee-dropdown-maintenance').val();
        var status = $(this).closest('tr').find('.status-dropdown').val();
    
        if (!assigneeId) {
            showSnackbar('Please select an assignee.', false);  // Show error Snackbar
            return;
        }
    
        $.ajax({
            url: 'housekeepingAndMaintenance/update_maintenance_assignee.php',
            method: 'POST',
            data: {
                id: scheduleId,
                assignee: assigneeId,
                status: status
            },
            success: function(response) {
                showSnackbar('Update successful!', true);  // Show success Snackbar
            },
            error: function(xhr, status, error) {
                showSnackbar('An error occurred: ' + error, false);  // Show error Snackbar
            }
        });
    });

    // Function to show snackbar
    function showSnackbar(message, isSuccess) {
        var snackbar = $('#snackbar');
        
        // Prevent stacking by hiding any existing snackbar before showing the new one
        snackbar.removeClass("show"); // Remove "show" class to hide any previous snackbar

        // Set the message and styling based on success or error
        snackbar.text(message);
        if (isSuccess) {
            snackbar.css('background-color', 'green'); // Green for success
        } else {
            snackbar.css('background-color', '#f44336'); // Red for error
        }

        // Show the snackbar
        snackbar.addClass('show');

        // Hide the snackbar after 3 seconds
        setTimeout(function() {
            snackbar.removeClass('show');
        }, 3000);
    }
});
