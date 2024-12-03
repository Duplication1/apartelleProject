$(document).ready(function() {
    // Initialize DataTable

    // Handle individual status update (maintenance tasks)
    $(document).on('click', '.btn-update-maintenance', function() {
        var status = $(this).closest('tr').find('.status-dropdown').val();
        var taskId = $(this).data('id');  // Fetch maintenance schedule ID

        // Make sure the status is selected
        if (!status) {
            alert('Please select a status.');
            return;
        }

        $.ajax({
            url: 'housekeepingAndMaintenance/update_maintenance_schedule.php',  // PHP backend to handle the status update for maintenance
            method: 'POST',
            data: {
                id: taskId,    // Maintenance task ID to update
                status: status // New status to set
            },
            success: function(response) {
                var responseData = JSON.parse(response);  // Parse the JSON response

                if (responseData.success) {
                    alert('Status updated successfully!');
                    location.reload();  // Reload the page to show the updated status
                } else {
                    alert('Error: ' + responseData.error);  // Show error message from backend
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);  // Alert if there's an issue with the AJAX request
            }
        });
    });

    // Handle update all maintenance dates
    $('#btn-update-all-maintenance').on('click', function() {
        var newDate = $('#updateDateInputMaintenance').val();  // Get the new date from the input

        if (!newDate) {
            alert('Please select a date before updating all tasks.');
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
                    alert('All maintenance dates updated successfully!');
                    location.reload();  // Reload the page to reflect the changes
                } else {
                    alert('Error: ' + responseData.error);  // Show error message from backend
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);  // Alert if there's an issue with the AJAX request
            }
        });
    });

    // Handle assignee update for maintenance tasks
    $(document).on('click', '.btn-update-maintenance', function() {
        var scheduleId = $(this).data('id');
        var assigneeId = $(this).closest('tr').find('.assignee-dropdown-maintenance').val();
        var status = $(this).closest('tr').find('.status-dropdown').val();
    
        if (!assigneeId) {
            alert('Please select an assignee.');
            return;
        }
    
        // Make an AJAX call or form submission here
        $.ajax({
            url: 'housekeepingAndMaintenance/update_maintenance_assignee.php',
            method: 'POST',
            data: {
                id: scheduleId,
                assignee: assigneeId,
                status: status
            },
            success: function(response) {
                // Handle the response
                alert('Update successful!');
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
