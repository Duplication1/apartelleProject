<?php
// Database connection parameters
$host = 'localhost';
$db = 'apartelle_db';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Get data from AJAX request
$schedule_id = isset($_POST['schedule_id']) ? $_POST['schedule_id'] : null;
$assignee_name = isset($_POST['assignee_name']) ? $_POST['assignee_name'] : null;

// Validate the input
if (empty($schedule_id) || empty($assignee_name)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input. Schedule ID and Assignee Name are required.']);
    exit();
}

// Prepare the SQL statement
$sql = "UPDATE cleaning_schedules SET assignee = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'SQL prepare failed: ' . $conn->error]);
    exit();
}

// Bind the parameters
$stmt->bind_param("si", $assignee_name, $schedule_id);

// Execute the query
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Assignee updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No rows updated. Check if the input values are correct or if the assignee is the same.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query execution failed: ' . $stmt->error]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
