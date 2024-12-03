<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'apartelle_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get POST data
$stockId = $_POST['stock_id'];
$newQuantity = $_POST['quantity'];

// Update query
$sql = "UPDATE inventory_pricelist_tbl SET item_quantity = ? WHERE stock_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $newQuantity, $stockId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Quantity updated successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating quantity: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
