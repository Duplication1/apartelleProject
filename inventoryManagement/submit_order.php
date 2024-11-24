<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apartelle_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Log the received data
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

// Check if all required fields are set
if (isset($_POST['item_name'], $_POST['quantity'], $_POST['price'], $_POST['type'])) {
    $item_names = $_POST['item_name'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['price'];
    $types = $_POST['type'];
    $created_at = date("Y-m-d H:i:s");

    // Insert into orders table once
    $sql_order = "INSERT INTO orders (created_at, status) VALUES ('$created_at', 'Pending')";
    if ($conn->query($sql_order)) {
        $order_id = $conn->insert_id; // Get the newly created order ID

        // Insert multiple items into the order_items table
        for ($i = 0; $i < count($item_names); $i++) {
            $item_name = $conn->real_escape_string($item_names[$i]);
            $quantity = (int)$conn->real_escape_string($quantities[$i]);
            $price = (float)$conn->real_escape_string($prices[$i]);
            $type = $conn->real_escape_string($types[$i]);
            $total_price = $quantity * $price;

            $sql_item = "INSERT INTO order_items (order_id, item_name, quantity, price, total_price, type) 
                         VALUES ('$order_id', '$item_name', '$quantity', '$price', '$total_price', '$type')";
            $conn->query($sql_item);
        }
        echo "Order submitted successfully!";
    } else {
        echo "Error inserting order: " . $conn->error;
    }
} else {
    echo "Please provide all required fields.";
}


$conn->close();
?>
