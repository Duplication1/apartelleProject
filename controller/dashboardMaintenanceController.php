<?php
// 1. Database connection function


// 2. Fetch maintenance schedule data
function fetchMaintenanceSchedules() {
    $conn = dbConnect();
    $sql = "SELECT issue, status FROM maintenance_schedules";  // Modify table name and fields as needed
    $result = $conn->query($sql);

    $schedules = [];
    if ($result->num_rows > 0) {
        // Fetch all rows as an associative array
        while($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
    }
    $conn->close();
    return $schedules;
}

// 3. Display data in a Bootstrap striped table
function displayMaintenanceSchedulesTable() {
    $schedules = fetchMaintenanceSchedules();
    if (empty($schedules)) {
        echo "<p>No maintenance schedules available.</p>";
        return;
    }

    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Issue</th><th>Status</th></tr></thead>';
    echo '<tbody>';

    // Loop through the data and display each row
    foreach ($schedules as $schedule) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($schedule['issue']) . '</td>';
        echo '<td>' . htmlspecialchars($schedule['status']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>