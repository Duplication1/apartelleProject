<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

// Check the database connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Ensure all necessary POST variables are set
if (!isset($_POST['evaluation_id'], $_POST['evaluation_date'], $_POST['remarks'], $_POST['evaluator_name'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit();
}

// Get the values from the POST request
$evaluation_id = $_POST['evaluation_id'];
$evaluation_date = $_POST['evaluation_date'];
$remarks = $_POST['remarks'];
$evaluator_name = $_POST['evaluator_name'];

// Ensure the date format is consistent for the database (use `Y-m-d H:i:s` format for MySQL)
$formatted_date = date('Y-m-d H:i:s', strtotime($evaluation_date));

// Prepare the SQL query to update the evaluation record
$updateQuery = "UPDATE evaluation_tbl SET remarks = ?, evaluation_date = ?, evaluator_name = ? WHERE evaluation_id = ?";
$stmt = $conn->prepare($updateQuery);

if ($stmt === false) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    exit();
}

// Bind parameters and execute the query
$stmt->bind_param("sssi", $remarks, $formatted_date, $evaluator_name, $evaluation_id);
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'Evaluation updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update the evaluation. It may not exist or no changes were made']);
}

$stmt->close();
$conn->close();
?>
