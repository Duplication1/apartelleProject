<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "apartelle_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT order_id, status FROM orders";
$result_orders = $conn->query($sql);

// Initialize variables for total quantity and total price
$total_quantity = 0;
$total_price = 0;


