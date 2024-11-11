<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance and Cleaning Schedules</title> 
</head>
<body>

<div class="container pt-5">
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ASSIGNEE</th>
                <th>DAY</th>
                <th>TASK TYPE</th> <!-- TASK TYPE column -->
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

            // Fetch data from both maintenance_schedules and cleaning_schedules tables
            $sql = "
                SELECT 
                    ms.id AS task_id, 
                    ms.scheduled_date AS date, 
                    CONCAT(e.firstname, ' ', e.lastname) AS assignee_name, 
                    e.job AS assignee_job
                FROM maintenance_schedules ms
                LEFT JOIN employee_tbl e ON ms.assignee = e.employee_id

                UNION

                SELECT 
                    cs.id AS task_id, 
                    cs.cleaning_date AS date, 
                    CONCAT(e.firstname, ' ', e.lastname) AS assignee_name, 
                    e.job AS assignee_job
                FROM cleaning_schedules cs
                LEFT JOIN employee_tbl e ON cs.assignee = e.employee_id
            ";

            $result = $conn->query($sql);

            // Check if there are results and display them in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Get the scheduled day from the scheduled date (assuming it's a DATETIME format)
                    $day = date('l', strtotime($row['date']));
                    // Determine the task type based on the job
                    $task_type = ($row['assignee_job'] == 'Cleaner') ? 'Cleaning' : 'Maintenance';
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['assignee_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($day) . "</td>";
                    echo "<td>" . htmlspecialchars($task_type) . "</td>"; // Display task type (Cleaning or Maintenance)
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }

            // Close the connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>


<script>
new DataTable('#example');
</script>

</body>
</html>
