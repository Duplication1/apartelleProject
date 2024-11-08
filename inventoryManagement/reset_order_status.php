<?php
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

// SQL to reset statuses for orders older than 24 hours
$reset_sql = "UPDATE deliver_items_tbl SET status = 'Order Placement', latest_track = NOW() WHERE created_at < NOW() - INTERVAL 1 DAY";

// Execute status reset
if ($conn->query($reset_sql) === TRUE) {
    echo "Order statuses reset successfully.";
} else {
    echo "Error resetting statuses: " . $conn->error;
}

// SQL to clear status history
$clear_history_sql = "DELETE FROM status_history_tbl WHERE created_at < NOW() - INTERVAL 1 DAY"; // Adjust table name as necessary

// Execute history reset
if ($conn->query($clear_history_sql) === TRUE) {
    echo "Status history cleared successfully.";
} else {
    echo "Error clearing status history: " . $conn->error;
}

$conn->close(); // Close the database connection
?>
