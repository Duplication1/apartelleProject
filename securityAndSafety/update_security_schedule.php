<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data was sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch the posted data
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $location = isset($_POST['location']) ? $conn->real_escape_string($_POST['location']) : '';
    $schedule_date = isset($_POST['schedule_date']) ? $conn->real_escape_string($_POST['schedule_date']) : '';

    // Check if the required data is present
    if ($id > 0 && !empty($location) && !empty($schedule_date)) {
        // Update the schedule in the database
        $update_query = "
            UPDATE security_schedules 
            SET location = '$location', schedule_date = '$schedule_date' 
            WHERE id = $id
        ";

        if ($conn->query($update_query) === TRUE) {
            // Success response
            echo "Schedule updated successfully.";
        } else {
            // Error response
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Invalid input. Please ensure all fields are filled out.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>
