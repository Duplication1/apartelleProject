<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Schedules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <style>
        .stock-levels-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .stock-levels-table th, .stock-levels-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .stock-levels-table th {
            background-color: #f2f2f2;
        }
        .stock-levels-table tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<div class="container pt-5">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Room Type</th>
                <th>
                    <form id="updateDateForm" action="housekeepingAndMaintenance/update_schedule.php" method="POST">
                        <div class="d-flex align-items-center">
                            <label for="updateDateInput" class="mr-2">Date:</label>
                            <input type="datetime-local" id="updateDateInput" name="newDate" class="form-control mt-1" style="width: auto; display: inline-block;" />
                            <button type="submit" id="btn-update-all" class="btn-update btn-sm mt-1" style="margin-left: 5px;">Update All</button>
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

        // Fetch data from the cleaning_schedules table, including the assignee's name
        $sql = "
            SELECT 
                cs.id, 
                cs.room_number, 
                cs.room_type, 
                cs.cleaning_date, 
                CONCAT(e.firstname, ' ', e.lastname) AS assignee_name, 
                cs.status, 
                cs.assignee
            FROM cleaning_schedules cs
            LEFT JOIN employee_tbl e ON cs.assignee = e.employee_id
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='display:none;'>" . htmlspecialchars($row['id']) . "</td>"; // Hidden ID
                echo "<td>" . htmlspecialchars($row['room_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
                echo "<td class='date-cell'>" . htmlspecialchars($row['cleaning_date']) . "</td>";

                // Assignee dropdown is moved to the "Assignee" column now
                echo "<td>
                    <select class='form-select assignee-dropdown' data-schedule-id='" . $row['id'] . "'>
                    <option value=''>Select Assignee</option>";

                // Fetch available cleaners for the dropdown list **inside the loop** (to ensure each row gets its own options)
                $cleanersSql = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS name FROM employee_tbl WHERE job = 'Cleaner'";
                $cleanersResult = $conn->query($cleanersSql);

                // Check if there are any cleaners available and populate the dropdown
                if ($cleanersResult->num_rows > 0) {
                    while ($cleaner = $cleanersResult->fetch_assoc()) {
                        $selected = ($row['assignee'] == $cleaner['employee_id']) ? ' selected' : '';
                        echo "<option value='" . $cleaner['employee_id'] . "'$selected>" . htmlspecialchars($cleaner['name']) . "</option>";
                    }
                }

                echo "</select></td>";

                // Status dropdown is now moved to the "Status" column
                echo "<td class='status-cell'>
                    <select class='form-select status-dropdown'>
                        <option value='In Progress'" . ($row['status'] == 'In Progress' ? ' selected' : '') . ">In Progress</option>
                        <option value='Clean'" . ($row['status'] == 'Clean' ? ' selected' : '') . ">Clean</option>
                        <option value='Dirty'" . ($row['status'] == 'Dirty' ? ' selected' : '') . ">Dirty</option>
                        <option value='Out of Order'" . ($row['status'] == 'Out of Order' ? ' selected' : '') . ">Out of Order</option>
                    </select>
                    <button class='btn btn-primary btn-update' data-id='" . $row['id'] . "' style='margin-left: 5px;'>Update</button>
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
