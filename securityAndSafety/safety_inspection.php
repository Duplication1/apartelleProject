<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch security personnel for the dropdown list
$security_query = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS full_name FROM employee_tbl WHERE job = 'Security'";
$security_result = $conn->query($security_query);

// Fetch all security schedules
$schedule_query = "SELECT id, location, schedule_date, assignee FROM security_schedules";
$schedule_result = $conn->query($schedule_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Security Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>

<div class="container pt-5">
    <h2>Update Security Schedules</h2>
    <table id="security-schedule-table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Location</th>
            <th>Assignee</th>
            <th>Schedule Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch security schedules from the database
        $result = $conn->query("SELECT * FROM security_schedules");
        
        while ($row = $result->fetch_assoc()) {
            $scheduleId = $row['id'];
            $location = $row['location'];
            $scheduleDate = $row['schedule_date'];
            $assignee = $row['assignee'];

            // Get assignee name
            $assigneeQuery = "SELECT CONCAT(firstname, ' ', lastname) AS full_name FROM employee_tbl WHERE employee_id = $assignee";
            $assigneeResult = $conn->query($assigneeQuery);
            $assigneeName = $assigneeResult->fetch_assoc()['full_name'];
        ?>
        <tr data-id="<?php echo $scheduleId; ?>">
            <td><?php echo $scheduleId; ?></td>
            <td>
                <select name="location_<?php echo $scheduleId; ?>" class="form-select location-dropdown">
                    <option value="Park Area" <?php echo ($location == 'Park Area' ? 'selected' : ''); ?>>Park Area</option>
                    <option value="Entrance" <?php echo ($location == 'Entrance' ? 'selected' : ''); ?>>Entrance</option>
                    <option value="Hotel" <?php echo ($location == 'Hotel' ? 'selected' : ''); ?>>Hotel</option>
                </select>
            </td>
            <td><?php echo $assigneeName; ?></td>
            <td>
                <input type="datetime-local" name="schedule_date_<?php echo $scheduleId; ?>" value="<?php echo date('Y-m-d\TH:i', strtotime($scheduleDate)); ?>" class="form-control schedule-date-input">
            </td>
            <td>
                <button type="button" class="btn btn-primary update-schedule-btn" data-id="<?php echo $scheduleId; ?>">Update</button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

    <div class="mt-3">
        <h3>Update All Schedules' Security Date</h3>
        <input type="datetime-local" id="updateDateInput" class="form-control">
        <button type="button" id="btn-update-security-date" class="btn btn-warning mt-2">Update Security Date</button>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Handle individual schedule update
    $(document).on('click', '.update-schedule-btn', function() {
        var scheduleId = $(this).data('id');

        // Get the updated values from the input fields
        var location = $("select[name='location_" + scheduleId + "']").val();
        var scheduleDate = $("input[name='schedule_date_" + scheduleId + "']").val();

        // AJAX request to update the schedule
        $.ajax({
            url: 'update_security_schedule.php',
            method: 'POST',
            data: {
                id: scheduleId,
                location: location,
                schedule_date: scheduleDate
            },
            success: function(response) {
                alert('Schedule updated successfully!');
                location.reload();  // Reload the page to show the updated data
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

    // Handle update all schedules' security date
    $('#btn-update-security-date').on('click', function() {
        var newDate = $('#updateDateInput').val();

        if (!newDate) {
            alert('Please select a date before updating all schedules.');
            return;
        }

        $.ajax({
            url: 'update_all_security_schedules.php',  // Update this with your backend PHP file for batch updates
            method: 'POST',
            data: {
                newDate: newDate
            },
            success: function(response) {
                alert('All security schedules updated successfully!');
                location.reload();  // Reload the page to show the updated data
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});
</script>

</body>
</html>

<?php
$conn->close();
?>
