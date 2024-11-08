<?php
// Database connection
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

// Determine the filter type
$filterType = isset($_POST['filter']) ? $_POST['filter'] : 'All';

// Prepare the SQL query based on the filter
if ($filterType == 'All') {
    $sql = "SELECT stock_id, item_name, item_type, item_quantity, item_image FROM inventory_pricelist_tbl";
} else {
    $sql = "SELECT stock_id, item_name, item_type, item_quantity, item_image FROM inventory_pricelist_tbl WHERE item_type = ?";
}

// Prepare statement
$stmt = $conn->prepare($sql);
if ($filterType != 'All') {
    $stmt->bind_param("s", $filterType); // Bind the filter type
}
$stmt->execute();
$result = $stmt->get_result();

$items = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row; // Store each row in an array
    }
}

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    
    </style>

</head>
<body>

<div class="container pt-5">
    
    <!-- Filter Buttons -->
    <button onclick="filterItems('All')" class="stock-filter-buttons">ALL</button>
    <button onclick="filterItems('Staff')" class="stock-filter-buttons">STAFF</button>
    <button onclick="filterItems('Bathroom')" class="stock-filter-buttons">BATHROOM</button>
    <button onclick="filterItems('Bedroom')" class="stock-filter-buttons">BEDROOM</button>
    <button onclick="filterItems('Electricity')" class="stock-filter-buttons">ELECTRICITY</button>
    <button onclick="filterItems('Water')" class="stock-filter-buttons">WATER</button>

    <table class="table stock-table table-striped">
        <thead>
            <tr class="stock-tr stock-tr-head">
                <th scope="col">Item</th>
                <th scope="col">Type</th>
                <th scope="col">Name</th>
                <th scope="col">Item Quantity</th>
            </tr>
        </thead>
        <tbody class="" id="inventoryTable">
    <?php
    if (!empty($items)) {
        foreach ($items as $index => $row) {
            $imageData = base64_encode($row['item_image']);
            $src = 'data:image/jpeg;base64,' . $imageData;

            echo "<tr class='stock-tr'>
                    <td class='stock-td'><img src='{$src}' class='item-image' alt='Item Image'></td>
                    <td class='stock-td'>{$row['item_type']}</td>
                    <td class='stock-td'>{$row['item_name']}</td>
                    <td class='stock-td'>
                        <span id='display_quantity_{$row['stock_id']}' style='margin: 0 20px 0 20px' class='updated-stock'>{$row['item_quantity']}</span>
                        <input type='number' value='0' id='quantity_{$row['stock_id']}' min='0' class='stock-update-input'>
                        <button onclick='updateQuantity({$row['stock_id']})' class='update-stock-button'>Update</button>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr class='stock-tr'><td colspan='4' class='stock-td'>No data found</td></tr>";
    }
    ?>
</tbody>

    </table>
</div>

<script>

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>