$(document).on('click', '.update-schedule-btn', function() {
    var scheduleId = $(this).data('id');

    // Get the updated values from the input fields
    var location = $("select[name='location_" + scheduleId + "']").val();
    var scheduleDate = $("input[name='schedule_date_" + scheduleId + "']").val();
    var scheduleTime = $("input[name='schedule_time_" + scheduleId + "']").val(); // Get the selected time
    var assignee = $("select[name='assignee_" + scheduleId + "']").val(); // Get the selected assignee

    // Log the data to check if it's correct
    console.log({
        id: scheduleId,
        location: location,
        schedule_date: scheduleDate,
        assignee: assignee // Include the assignee
    });

    // AJAX request to update the schedule
    $.ajax({
        url: 'securityAndSafety/update_security_schedule.php',
        method: 'POST',
        data: {
            id: scheduleId,
            location: location,
            schedule_date: scheduleDate,
            schedule_time: scheduleTime,
            assignee: assignee // Send the assignee
        },
        success: function(response) {
            var jsonResponse = JSON.parse(response);
            if (jsonResponse.status === 'success') {
                showSnackbar(jsonResponse.message, 'success');
            } else {
                showSnackbar('Error: ' + jsonResponse.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            showSnackbar('Error: ' + error, 'error');
        }
    });
});

// Function to show the snackbar with a message (using previous snackbar code)
function showSnackbar(message, type) {
    var snackbar = document.createElement("div");
    snackbar.className = "snackbar " + type;
    snackbar.textContent = message;

    // Append snackbar to the body
    document.body.appendChild(snackbar);

    // Show the snackbar
    setTimeout(function() {
        snackbar.className = snackbar.className.replace("snackbar", "snackbar show");
    }, 100);

    // After 3 seconds, remove the snackbar
    setTimeout(function() {
        snackbar.className = snackbar.className.replace("show", "");
        setTimeout(function() {
            snackbar.remove();
        }, 500); // Allow for animation before removal
    }, 3000);
}
