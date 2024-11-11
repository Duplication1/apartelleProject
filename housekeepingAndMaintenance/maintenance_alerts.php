<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <style>
        .maintenance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .maintenance-table th, .maintenance-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .maintenance-table th {
            background-color: #f2f2f2;
        }
        .maintenance-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<div class="container pt-5">
<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Issue</th>
                <th>Location</th>
                <th>
                    <form id="updateDateForm" action="housekeepingAndMaintenance/update_maintenance_schedule.php" method="POST">
                        <div class="d-flex align-items-center">
                            <label for="updateDateInputMaintenance" class="mr-2">Date:</label>
                            <input type="datetime-local" id="updateDateInputMaintenance" name="newDate" class="form-control mt-1" style="width: auto; display: inline-block;" />
                            <button type="submit" id="btn-update-all-maintenance" class="btn-update btn-sm mt-1" style="margin-left: 5px;">Update All</button>
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

                // Assignee dropdown is moved to the "Assignee" column now
                echo "<td>
                    <select class='form-select assignee-dropdown-maintenance' data-schedule-id='" . $row['id'] . "'>
                    <option value=''>Select Assignee</option>";

                // Fetch available maintenance workers for the dropdown list **inside the loop** (to ensure each row gets its own options)
                $workersSql = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS name FROM employee_tbl WHERE job = 'Maintenance Worker'";
                $workersResult = $conn->query($workersSql);

                // Check if there are any maintenance workers available and populate the dropdown
                if ($workersResult->num_rows > 0) {
                    while ($worker = $workersResult->fetch_assoc()) {
                        $selected = ($row['assignee'] == $worker['employee_id']) ? ' selected' : '';
                        echo "<option value='" . $worker['employee_id'] . "'$selected>" . htmlspecialchars($worker['name']) . "</option>";
                    }
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
                    <button class='btn btn-primary btn-update btn-maintenance' data-id='" . $row['id'] . "' style='margin-left: 5px;'>Update</button>
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

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
// Your JavaScript or AJAX code here, e.g., to handle updates, etc.
</script>

</body>
</html>
