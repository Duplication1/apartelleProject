<div class="container pt-5">
    <table id="example" class="table table-striped table-cleaning" style="width:100%">
        <thead>
            <tr>
                <th>Room No.</th>
                <th>Room Type</th>
                <th>
                    <form id="updateDateForm" action="housekeepingAndMaintenance/update_schedule.php" method="POST">
                        <div class="d-flex align-items-center">
                            <label for="updateDateInput" class="mr-2">Date:</label>
                            <input type="datetime-local" id="updateDateInput" name="newDate" class="form-control mt-1" style="width: 45px; display: inline-block;" />
                            <button type="submit" id="btn-update-all" class="btn-update-schedule btn-update btn-sm mt-1 btn-cleaning-date" style="margin-left: 5px;">Update All</button>
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
        include_once("../connection/connection.php");
        $con = connection();

        // Fetch available cleaners for the dropdown list once
        $cleanersSql = "SELECT employee_id, CONCAT(firstname, ' ', lastname) AS name FROM employee_tbl WHERE JobTitle = 'Cleaner'";
        $cleanersResult = $con->query($cleanersSql);
        $cleaners = [];

        if ($cleanersResult->num_rows > 0) {
            while ($cleaner = $cleanersResult->fetch_assoc()) {
                $cleaners[] = $cleaner; // Store each cleaner in an array
            }
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
LEFT JOIN employee_tbl e ON cs.assignee = e.employee_id AND e.JobTitle= 'Cleaner'
        ";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='display:none;'>" . htmlspecialchars($row['id']) . "</td>"; // Hidden ID
                echo "<td>" . htmlspecialchars($row['room_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
                echo "<td class='date-cell'>" . htmlspecialchars($row['cleaning_date']) . "</td>";

                // Assignee dropdown
                echo "<td>
                    <select class='form-select assignee-dropdown' data-schedule-id='" . htmlspecialchars($row['id']) . "'>
                    <option value=''>Select Assignee</option>";

                // Populate the dropdown with available cleaners
                foreach ($cleaners as $cleaner) {
                    $selected = ($row['assignee'] === $cleaner['employee_id']) ? ' selected' : ''; // Use strict comparison
                    echo "<option value='" . htmlspecialchars($cleaner['employee_id']) . "'$selected>" . htmlspecialchars($cleaner['name']) . "</option>";
                }

                echo "</select></td>";

                // Status dropdown
                echo "<td class='status-cell'>
                    <select class='form-select status-dropdown'>
                        <option value='In Progress'" . ($row['status'] === 'In Progress' ? ' selected' : '') . ">In Progress</option>
                        <option value='Clean'" . ($row['status'] === 'Clean' ? ' selected' : '') . ">Clean</option>
                        <option value='Dirty'" . ($row['status'] === 'Dirty' ? ' selected' : '') . ">Dirty</option>
                        <option value='Out of Order'" . ($row['status'] === 'Out of Order' ? ' selected' : '') . ">Out of Order</option>
                    </select>
                    <button class='btn-update btn-cleaning-update' data-id='" . htmlspecialchars($row['id']) . "' style='margin-left: 5px;'>Update</button>
                </td>";

 echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No records found</td></tr>";
        }

        // Close the connection
        $con->close();
        ?>

        </tbody>
    </table>
</div>