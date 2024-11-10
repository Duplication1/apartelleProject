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
                <th>Assignee</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $host = 'localhost'; // XAMPP default host
            $db = 'apartelle_db'; // Database name
            $user = 'root'; // Default XAMPP username
            $pass = ''; // XAMPP usually has no password by default

            // Create connection
            $conn = new mysqli($host, $user, $pass, $db);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            // Fetch data from the database
            $sql = "SELECT id, room_number, room_type, cleaning_date, assignee, status FROM cleaning_schedules"; 
            $result = $conn->query($sql);

            // Check if there are results and loop through them
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='display:none;'>" . htmlspecialchars($row['id']) . "</td>"; // Hidden ID

                    echo "<td>" . htmlspecialchars($row['room_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['room_type']) . "</td>";
                    echo "<td class='date-cell'>" . htmlspecialchars($row['cleaning_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['assignee']) . "</td>";
                    echo "<td class='status-cell'>
                    <select class='form-select status-dropdown'>
                        <option value='In Progress'" . ($row['status'] == 'In Progress' ? ' selected' : '') . ">In Progress</option>
                        <option value='Clean'" . ($row['status'] == 'Clean' ? ' selected' : '') . ">Clean</option>
                        <option value='Dirty'" . ($row['status'] == 'Dirty' ? ' selected' : '') . ">Dirty</option>
                        <option value='Out of Order'" . ($row['status'] == 'Out of Order' ? ' selected' : '') . ">Out of Order</option>
                    </select>
                    <button class='btn btn-primary btn-update' style='margin-left: 5px;'>Update</button>
                    <td style='display:none;' class='room-id'>" . htmlspecialchars($row['id']) . "</td>
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

</body>
</html>