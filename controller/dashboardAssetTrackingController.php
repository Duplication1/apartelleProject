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

// Fetch data for dashboard summarization (ID and Status only)
$dashboard_sql = "SELECT id, status FROM deliver_items_tbl";
$dashboard_result = $conn->query($dashboard_sql);
?>