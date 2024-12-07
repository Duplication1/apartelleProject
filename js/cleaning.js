$(document).ready(function() {
    // Handle individual status update
    $(document).on('click', '.btn-update', function() {
        var status = $(this).closest('tr').find('.status-dropdown').val();
        var roomId = $(this).data('id');

        $.ajax({
            url: 'housekeepingAndMaintenance/update_schedule.php',  // URL to your PHP backend that handles the status update
            method: 'POST',
            data: {
                id: roomId,
                status: status
            },
            success: function(response) {
                showSnackbarV2('Status updated successfully!', 'success'); // Show success Snackbar
                setTimeout(function() {
                    location.reload();  // Reload the page after 2 seconds
                }, 2000);  // 2-second delay before reloading
            },
            error: function(xhr, status, error) {
                showSnackbarV2('Error: ' + error, 'error'); // Show error Snackbar
            }
        });
    });

    // Handle update all dates
    $('#btn-update-all').on('click', function(event) {
        event.preventDefault();  // Prevent form submission
        var newDate = $('#updateDateInput').val();
    
        if (!newDate) {
            showSnackbarV2('Please select a date before updating all rooms.', 'error');  // Show error Snackbar
            return;
        }
    
        $.ajax({
            url: 'housekeepingAndMaintenance/update_schedule.php',
            method: 'POST',
            data: {
                newDate: newDate
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response); // Parse the JSON response
                if (jsonResponse.success) {
                    showSnackbarV2('All cleaning dates updated successfully!', 'success'); // Show success Snackbar
                    setTimeout(function() {
                        // Redirect back to the previous page after 2 seconds
                        window.location.href = document.referrer;  
                    }, 2000);  // 2-second delay before redirecting
                } else {
                    showSnackbarV2('Error: ' + jsonResponse.error, 'error'); // Show error Snackbar
                }
            },
            error: function(xhr) {
                showSnackbarV2('Error: ' + xhr.responseText, 'error'); // Show error Snackbar in case of failure
            }
        });
    });

    // Handle cleaning assignee update
    $(document).on('click', '.btn-cleaning-update', function() {
        var scheduleId = $(this).data('id'); // Get the schedule ID from the button's data attribute
        var assigneeId = $(this).closest('tr').find('.assignee-dropdown').val(); // Get the selected assignee ID

        if (!assigneeId) {
            showSnackbarV2('Please select an assignee before updating.', 'error'); // Show error Snackbar
            return;
        }

        $.ajax({
            url: 'housekeepingAndMaintenance/update_assignee.php', // Update this to the correct PHP file
            method: 'POST',
            data: {
                schedule_id: scheduleId,
                assignee_name: assigneeId // Ensure you are using assigneeId here
            },
            success: function(response) {
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.status === 'success') {
                    showSnackbarV2(jsonResponse.message, 'success'); // Show success Snackbar
                    $('#example').DataTable().ajax.reload(); // Reload the DataTable to reflect changes
                } else {
                    showSnackbarV2('Error: ' + jsonResponse.message, 'error'); // Show error Snackbar
                }
            },
            error: function(xhr) {
                showSnackbarV2('Error: ' + xhr.responseText, 'error'); // Show error Snackbar in case of failure
            }
        });
    });
});

// Function to show snackbar with type ('success', 'error', 'info')
function showSnackbarV2(message, type) {
    // Generate a unique ID for each snackbar
    var uniqueId = 'snackbar-v2-' + new Date().getTime();

    // Check if there is already a snackbar present and remove it
    var existingSnackbar = document.querySelector(".snackbar-v2");
    if (existingSnackbar) {
        existingSnackbar.classList.remove("show"); // Hide the current snackbar
        existingSnackbar.remove();  // Remove the existing snackbar element
    }

    // Create a new snackbar element with a unique ID
    var snackbar = document.createElement("div");
    snackbar.className = "snackbar-v2 " + type;  // Apply the unique class based on the type
    snackbar.id = uniqueId;  // Set the unique ID
    snackbar.textContent = message;

    // Append the snackbar to the body
    document.body.appendChild(snackbar);

    // Trigger the show animation
    setTimeout(function() {
        snackbar.classList.add("show");
    }, 10);

    // Remove the snackbar after 2 seconds
    setTimeout(function() {
        snackbar.classList.remove("show");
        snackbar.remove();  // Remove the snackbar element after it's hidden
    }, 2000);  // 2-second delay before removal
}
