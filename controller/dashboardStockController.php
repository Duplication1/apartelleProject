<?php
// Database connection
$host = 'localhost';
$db = 'apartelle_db';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default filter type (can be set based on user selection)
$filterType = isset($_POST['filter']) ? $_POST['filter'] : 'All';

// Base SQL query to calculate the total quantity
$sql = "SELECT SUM(item_quantity) AS total_quantity FROM inventory_pricelist_tbl";

// Modify the query if a filter type is set (e.g., for 'Bathroom', 'Bedroom', etc.)
if ($filterType != 'All') {
    $sql .= " WHERE item_type = ?";
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameter if a filter type is applied
if ($filterType != 'All') {
    $stmt->bind_param("s", $filterType);
}

// Execute the query and fetch the result
$stmt->execute();
$result = $stmt->get_result();

// Initialize total quantity variable
$totalQuantity = 0; // Default value if no rows are returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalQuantity = $row['total_quantity'] ?? 0; // Set to 0 if no result
}

// Close the database connection
$stmt->close();
$conn->close();
?>
