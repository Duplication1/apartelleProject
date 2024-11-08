<?php
$host = 'localhost'; // XAMPP default host
$db = 'apartelle_db'; // Database name
$user = 'root'; // Default XAMPP username
$pass = ''; // XAMPP usually has no password by default

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$itemId = $_POST['item_id'];

// Fetch status history with dates
$history_sql = "SELECT status, updated_at FROM status_history_tbl WHERE item_id = ? ORDER BY updated_at DESC";
$stmt = $conn->prepare($history_sql);
$stmt->bind_param("i", $itemId);
$stmt->execute();
$result = $stmt->get_result();

$statusHistory = [];
while ($row = $result->fetch_assoc()) {
    $statusHistory[] =  $row['updated_at'];
}

echo implode(",", $statusHistory);
?>