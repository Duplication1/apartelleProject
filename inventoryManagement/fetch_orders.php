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

// SQL query to fetch all orders
$sql = "SELECT order_id, item_name, quantity, price, (quantity * price) AS total_price, created_at, status FROM order_requests";

// Execute the query
$result = $conn->query($sql);

// Prepare an array to store the fetched orders
$orders = array();

// Check if there are any results
if ($result->num_rows > 0) {
    // Fetch and store each order in the orders array
    while ($row = $result->fetch_assoc()) {
        $orders[] = array(
            'order_id'   => $row['order_id'],
            'item_name'  => $row['item_name'],
            'quantity'   => $row['quantity'],
            'price'      => $row['price'],
            'total_price'=> $row['total_price'],
            'created_at' => $row['created_at'],
            'status'     => $row['status']
        );
    }
}

// Close the database connection
$conn->close();

// Return the orders as a JSON response
echo json_encode(array('orders' => $orders));
?>
