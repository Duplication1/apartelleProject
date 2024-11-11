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

// Get data from AJAX request
$schedule_id = $_POST['schedule_id'];
$assignee_id = $_POST['assignee_id'];

// Validate the input
if (empty($schedule_id) || empty($assignee_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit();
}

// Update assignee in cleaning_schedules table
$sql = "UPDATE cleaning_schedules SET assignee = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'SQL prepare failed: ' . $conn->error]);
    exit();
}

// Bind the parameters (assignee_id and schedule_id are both integers)
$stmt->bind_param("ii", $assignee_id, $schedule_id);

// Execute the query
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Assignee updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error updating assignee or no change made']);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
