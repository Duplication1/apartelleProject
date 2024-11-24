<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the values from the POST request
$evaluation_id = $_POST['evaluation_id'];
$evaluation_date = $_POST['evaluation_date'];
$remarks = $_POST['remarks'];
$evaluator_name = $_POST['evaluator_name'];

// Ensure the date format is consistent for the database (use `Y-m-d H:i:s` format for MySQL)
$formatted_date = date('Y-m-d H:i:s', strtotime($evaluation_date));

// Update the evaluation record
$updateQuery = "UPDATE evaluation_tbl SET remarks = ?, evaluation_date = ?, evaluator_name = ? WHERE evaluation_id = ?";
$stmt = $conn->prepare($updateQuery);
$stmt->bind_param("sssi", $remarks, $formatted_date, $evaluator_name, $evaluation_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo 'Evaluation updated successfully';
} else {
    echo 'Failed to update the evaluation';
}

$stmt->close();
$conn->close();
?>
