<?php
// 1. Database connection function
function dbConnect() {
    $servername = "localhost"; // Replace with your database server
    $username = "root";        // Replace with your database username
    $password = "";            // Replace with your database password
    $dbname = "apartelle_db"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// 2. Fetch cleaning schedule data
function fetchCleaningSchedules() {
    $conn = dbConnect();
    $sql = "SELECT room_number, status FROM cleaning_schedules";  // Modify table name and fields as needed
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
function displayCleaningSchedulesTable() {
    $schedules = fetchCleaningSchedules();
    if (empty($schedules)) {
        echo "<p>No cleaning schedules available.</p>";
        return;
    }

    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Room Number</th><th>Status</th></tr></thead>';
    echo '<tbody>';

    // Loop through the data and display each row
    foreach ($schedules as $schedule) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($schedule['room_number']) . '</td>';
        echo '<td>' . htmlspecialchars($schedule['status']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>
