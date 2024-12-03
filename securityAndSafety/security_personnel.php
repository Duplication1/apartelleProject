<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch security personnel for the dropdown list
$security_query = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS full_name FROM employee_tbl WHERE JobTitle = 'Security'";
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
<td>
    <select name="assignee_<?php echo $scheduleId; ?>" class="form-select security-dropdown">
    <?php
    // Populate the dropdown with security personnel
    $security_result->data_seek(0); // Reset the pointer to reuse the result set
    while ($security_row = $security_result->fetch_assoc()) {
        $selected = ($security_row['employee_id'] == $assignee) ? 'selected' : '';
        echo '<option value="' . $security_row['employee_id'] . '" ' . $selected . '>' . $security_row['full_name'] . '</option>';
    }
    ?>
    </select>
</td>
    <td>
    <input type="date" name="schedule_date_<?php echo $scheduleId; ?>" value="<?php echo date('Y-m-d', strtotime($scheduleDate)); ?>" class="form-control schedule-date-input">
</td>
    <td>
        <button type="button" class="update-schedule-btn btn btn-primary" data-id="<?php echo $scheduleId; ?>">Update</button>
    </td>
</tr>
<?php } ?>

    </tbody>
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Handle the update button click event using AJAX

</script>

</body>
</html>

<?php
$conn->close();
?>
