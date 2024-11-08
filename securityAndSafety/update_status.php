<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "apartelle_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the data from the POST request
$id = $_POST['id'];
$status = $_POST['status'];

// Prepare and execute the SQL statement
$sql = "UPDATE incident_report_tbl SET incident_status = ? WHERE incident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo "Status updated successfully";
} else {
    echo "Error updating status: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
