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

// Check if data is received from the form
if (isset($_POST['item_name']) && isset($_POST['quantity']) && isset($_POST['price']) && isset($_POST['created_at'])) {
    // Sanitize and assign the form data
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $created_at = mysqli_real_escape_string($conn, $_POST['created_at']);

    // Calculate the total price
    $total_price = $quantity * $price;

    // Check if the item already exists (based on item_name)
    $sql_check = "SELECT * FROM order_requests WHERE item_name = '$item_name' LIMIT 1";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Item exists, update the row
        $sql_update = "UPDATE order_requests 
                       SET quantity = '$quantity', price = '$price', total_price = '$total_price', created_at = '$created_at', status = 'Pending' 
                       WHERE item_name = '$item_name'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "Order updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Item doesn't exist, insert new row
        $sql_insert = "INSERT INTO order_requests (item_name, quantity, price, total_price, created_at, status) 
                       VALUES ('$item_name', '$quantity', '$price', '$total_price', '$created_at', 'Pending')";
        
        if ($conn->query($sql_insert) === TRUE) {
            echo "Order submitted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Close connection
    $conn->close();
} else {
    // If required fields are missing
    echo "Please fill all the fields!";
}
?>
