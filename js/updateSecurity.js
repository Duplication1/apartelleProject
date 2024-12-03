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
                alert(jsonResponse.message);
            } else {
                alert('Error: ' + jsonResponse.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error: ' + error);
        }
    });
});