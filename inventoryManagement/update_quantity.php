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

// Get data from POST request
$stockId = $_POST['stock_id'];
$newQuantity = $_POST['quantity'];

// Prepare the SQL update statement
$sql = "UPDATE inventory_pricelist_tbl SET item_quantity = ? WHERE stock_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $newQuantity, $stockId);

if ($stmt->execute()) {
    echo "Quantity updated successfully.";
} else {
    echo "Error updating quantity: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

