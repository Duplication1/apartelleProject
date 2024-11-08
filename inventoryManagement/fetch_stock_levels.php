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

// Output the HTML table rows
if (!empty($items)) {
    foreach ($items as $index => $row) {
        $imageData = base64_encode($row['item_image']);
        $src = 'data:image/jpeg;base64,' . $imageData;

        // Determine the row class based on index
        $rowClass = ($index % 2 == 0) ? 'row-white' : 'row-light';

        echo "<tr class='stock-tr'>
        <td class='stock-td'><img src='{$src}' class='item-image' alt='Item Image'></td>
        <td class='stock-td'>{$row['item_type']}</td>
        <td class='stock-td'>{$row['item_name']}</td>
         <td class='stock-td'>
                        <span id='display_quantity_{$row['stock_id']}' style='margin: 0 20px 0 20px;' class='updated-stock'>{$row['item_quantity']}</span>
                        <input type='number' value='0' id='quantity_{$row['stock_id']}' min='0' class='stock-update-input' >
                        <button onclick='updateQuantity({$row['stock_id']})' class='update-stock-button'>Update</button>
                        
        </td>
    </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='stock-td'>No data found</td></tr>";
}
?>


<script>
function updateQuantity(stockId) {
    var newQuantity = document.getElementById('quantity_' + stockId).value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "inventoryManagement/update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert(xhr.responseText); // Handle the response from the server
            location.reload(); // Optionally reload the page to reflect changes
        }
    };
    xhr.send("stock_id=" + stockId + "&quantity=" + newQuantity);
}
</script>

