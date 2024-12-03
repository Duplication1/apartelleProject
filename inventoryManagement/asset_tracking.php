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

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id']) && isset($_POST['new_status'])) {
    $item_id = $_POST['item_id'];
    $new_status = $_POST['new_status'];

    // Fetch current status to check the current state
    $current_status_sql = "SELECT status FROM deliver_items_tbl WHERE id = ?";
    $stmt = $conn->prepare($current_status_sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    // Debugging output
    error_log("Current Status: $current_status, New Status: $new_status");

    // Define the status progression
    $statuses = ['Order Placement', 'Packing', 'Shipping', 'Delivered'];
    $current_status_index = array_search($current_status, $statuses);
    $new_status_index = array_search($new_status, $statuses);

    // Check if the new status is the next one in the progression
    if ($new_status_index === false || $new_status_index <= $current_status_index) {
        echo json_encode(['success' => false, 'message' => 'Invalid status update.']);
    } else {
        // Update the status
        $update_sql = "UPDATE deliver_items_tbl SET status = ?, latest_track = NOW(), updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $new_status, $item_id);

      // Inside the PHP script that updates the status (asset_tracking.php):

// After updating the status in the database
if ($stmt->execute()) {
    // Insert into status_history_tbl
    $insert_history_sql = "INSERT INTO status_history_tbl (item_id, status, updated_at) VALUES (?, ?, NOW())";
    $history_stmt = $conn->prepare($insert_history_sql);
    $history_stmt->bind_param("is", $item_id, $new_status);

    if ($history_stmt->execute()) {
        // Success, return a JSON response
        echo json_encode([
            'success' => true,
            'message' => 'Status updated successfully!',
            'new_status' => $new_status,
            'latest_track' => date('Y-m-d H:i:s') // Current timestamp for latest track
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error inserting status history: ' . $history_stmt->error
        ]);
    }
    
    $history_stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error updating status: ' . $stmt->error
    ]);
}
$stmt->close();

    }
    exit; // Exit after handling the AJAX request
}

// Fetch data from the deliver_items_tbl table
$sql = "SELECT id, item_name, latest_track, status FROM deliver_items_tbl";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <style>
        
        .table-asset-tracking{
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <div class="tracking-visual" id="trackingVisual">
        <div class="item-details-asset">
        <p>ITEM ID NUMBER: <span id="itemIdValue">Select an item to view details</span></p>
        <p>Item Name: <span id="itemNameValue"></span></p>
        <p>Latest Track: <span id="latestTrackValue"></span></p>
        <p>Current Status: <span id="currentStatusValue"></span></p>
        </div>
        <div class="tracking-nodes">
            <div class="noded" id="nodeOrderPlacement">Order Placement</div>
            <div class="noded" id="nodePacking">Packing</div>
            <div class="noded" id="nodeShipping">Shipping</div>
            <div class="noded" id="nodeDelivered">Delivered</div>
            <div id="statusHistory"></div>
        </div>
    </div>
 
    <div class="table-asset-tracking">
    <table class="table table-striped asset-tracking-main-table" id="orderTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Latest Track</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $status = $row['status'];
                    $statuses = ['Order Placement', 'Packing', 'Shipping', 'Delivered'];
                    $currentStatusIndex = array_search($status, $statuses);

                    echo "<tr class='asset-tracking-tr'onclick=\"showItemDetails({$row['id']}, '{$row['item_name']}', '{$row['latest_track']}', '{$row['status']}')\">
                            <td>{$row['id']}</td>
                            <td>{$row['item_name']}</td>
                            <td>{$row['latest_track']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form method='post' class='updateStatusForm' data-id='{$row['id']}'>
                                    <select name='new_status' " . ($status === 'Delivered' ? 'disabled' : '') . ">";
                                    foreach ($statuses as $index => $option) {
                                        $disabled = $index < $currentStatusIndex ? 'disabled' : '';
                                        echo "<option value='{$option}' {$disabled}>{$option}</option>";
                                    }
                                    echo "</select>
                                    <input type='hidden' name='item_id' value='{$row['id']}'>
                                    <button type='submit' class='button-asset' " . ($status === 'Delivered' ? 'disabled' : '') . ">Update Status</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
       

<script>
   
</script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
