$(document).ready(function() {
    // Initialize DataTable


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
                alert('Status updated successfully!');
                location.reload();  // Reload the page to show the updated data
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

  // Handle update all dates
$('#btn-update-all').on('click', function(event) {
    event.preventDefault();  // Prevent form submission
    var newDate = $('#updateDateInput').val();

    if (!newDate) {
        alert('Please select a date before updating all rooms.');
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
                alert('All cleaning dates updated successfully!');
                $('#example').DataTable().ajax.reload(); // Update table data dynamically

                // Redirect back to the previous page
                window.location.href = document.referrer; // Redirect to the referring page
            } else {
                alert('Error: ' + jsonResponse.error); // Show error message from server
            }
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText); // Show detailed error message
        }
    });
});
    

$(document).on('click', '.btn-cleaning-update', function() {
    var scheduleId = $(this).data('id'); // Get the schedule ID from the button's data attribute
    var assigneeId = $(this).closest('tr').find('.assignee-dropdown').val(); // Get the selected assignee ID

    if (!assigneeId) {
        alert('Please select an assignee before updating.');
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
                alert(jsonResponse.message);
                $('#example').DataTable().ajax.reload(); // Reload the DataTable to reflect changes
            } else {
                alert('Error: ' + jsonResponse.message);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText); // Log the full response for debugging
            alert('Error: ' + xhr.responseText);
        }
    });
});
});
