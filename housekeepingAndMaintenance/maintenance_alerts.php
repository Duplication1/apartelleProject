

<div class="container pt-5">
<table id="example" class="table table-striped table-maintenance" style="width:100%">
        <thead>
            <tr>
                <th>Issue</th>
                <th>Location</th>
                <th>
                    <form id="updateDateForm" action="housekeepingAndMaintenance/update_maintenance_schedule.php" method="POST">
                        <div class="d-flex align-items-center">
                            <label for="updateDateInputMaintenance" class="mr-2">Date:</label>
                            <input type="datetime-local" id="updateDateInputMaintenance" name="newDate" class="form-control mt-1" style="width: 45px;" />
                            <button type="submit" id="btn-update-all-maintenance" class="btn-update btn-sm mt-1 btn-maintenance-date" style="margin-left: 5px;">Update All</button>
                        </div>
                    </form>
                </th>
                <th>Assignee</th> <!-- Assignee Column -->
                <th>Status</th> <!-- Status Column -->
            </tr>
        </thead>
        <tbody>
        <?php
// Database connection
$host = 'localhost';
$db = 'apartelle_db';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch available maintenance workers once
$workersSql = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS name FROM employee_tbl WHERE JobTitle = 'Maintenance'";
$workersResult = $conn->query($workersSql);
$workers = [];

if ($workersResult->num_rows > 0) {
    while ($worker = $workersResult->fetch_assoc()) {
        $workers[$worker['employee_id']] = htmlspecialchars($worker['name']);
    }
}

// Fetch data from the maintenance_schedules table, including the assignee's name
$sql = "
    SELECT 
        ms.id, 
        ms.issue, 
        ms.location, 
        ms.scheduled_date, 
        CONCAT(e.firstname, ' ', e.lastname) AS assignee_name, 
        ms.status, 
        ms.assignee
    FROM maintenance_schedules ms
    LEFT JOIN employee_tbl e ON ms.assignee = e.employee_id
";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='display:none;'>" . htmlspecialchars($row['id']) . "</td>"; // Hidden ID
        echo "<td>" . htmlspecialchars($row['issue']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td class='date-cell'>" . htmlspecialchars($row['scheduled_date']) . "</td>";

        // Assignee dropdown now uses the pre-fetched workers
        echo "<td>
            <select class='form-select assignee-dropdown-maintenance' data-schedule-id='" . $row['id'] . "'>
            <option value=''>Select Assignee</option>";

            foreach ($workers as $workerId => $workerName) {
                // Use strict comparison for checking the assignee
                $selected = (string)$row['assignee'] === (string)$workerId ? ' selected' : '';
                
                // Use htmlspecialchars to escape output for security
                echo "<option value='" . htmlspecialchars($workerId, ENT_QUOTES, 'UTF-8') . "'$selected>" . htmlspecialchars($workerName, ENT_QUOTES, 'UTF-8') . "</option>";
            }
        echo "</select></td>";

        // Status dropdown is now moved to the "Status" column
        echo "<td class='status-cell'>
            <select class='form-select status-dropdown'>
                <option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                <option value='In Progress'" . ($row['status'] == 'In Progress' ? ' selected' : '') . ">In Progress</option>
                <option value='Completed'" . ($row['status'] == 'Completed' ? ' selected' : '') . ">Completed</option>
                <option value='On Hold'" . ($row['status'] == 'On Hold' ? ' selected' : '') . ">On Hold</option>
            </select>
            <button class='btn btn-update-maintenance' data-id='" . $row['id'] . "' style='margin-left: 5px;'>Update</button>
        </td>";

        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}

// Close the connection
$conn->close();
?>
        </tbody>
    </table>
</div>
