<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Order Form</h2>
    <form id="orderReportForm" enctype="multipart/form-data" class="order-form">
        <div class="order-items">
            <div class="order-item row mb-3">
                <div class="col-md-2">
                    <label for="orderItemName" class="form-label">Item Name</label>
                    <input type="text" class="form-control" name="item_name[]" required>
                </div>
                <div class="col-md-2">
                    <label for="orderQuantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="quantity[]" required>
                </div>
                <div class="col-md-2">
                    <label for="orderPrice" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" name="price[]" required>
                </div>
                <div class="col-md-2">
                    <label for="orderType" class="form-label">Type</label>
                    <input type="text" class="form-control" name="type[]" placeholder="e.g., Electronics, Grocery" required>
                </div>
                <div class="col-md-2">
                    <label for="orderDate" class="form-label">Order Date</label>
                    <input type="date" class="form-control" name="created_at[]" required>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item" style="margin-top: 32px;">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" id="addItemButton" class="btn btn-secondary mb-3">Add Another Item</button>
        
        <div class="d-flex justify-content-start">
            <button type="button" id="submitButtonOrder" class="btn btn-primary">Save</button>
        </div>
    </form>

    <div id="responseMessage" class="mt-3"></div>

    <h3 class="reported-orders">Reported Orders</h3>
    <table class="table table-striped mt-3" id="orderTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Type</th>
            <th>Total</th>
            <th>Order Date</th>
            <th>Status</th>
        </tr>
    </thead>
        <tbody>
        <?php
        $servername = "localhost";
        $username = "root"; // Your database username
        $password = ""; // Your database password
        $dbname = "apartelle_db"; // Your database name
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT 
        o.order_id, 
        o.created_at, 
        o.status, 
        GROUP_CONCAT(i.item_name ORDER BY i.item_id SEPARATOR '<br>') AS items, 
        GROUP_CONCAT(i.quantity ORDER BY i.item_id SEPARATOR '<br>') AS quantities,
        GROUP_CONCAT(i.price ORDER BY i.item_id SEPARATOR '<br>') AS prices,
        GROUP_CONCAT(i.type ORDER BY i.item_id SEPARATOR '<br>') AS types,
        GROUP_CONCAT(i.total_price ORDER BY i.item_id SEPARATOR '<br>') AS totals
    FROM orders o
    JOIN order_items i ON o.order_id = i.order_id
    GROUP BY o.order_id";



$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['order_id']}</td>
                <td>{$row['items']}</td>
                <td>{$row['quantities']}</td>
                <td>{$row['prices']}</td>
                <td>{$row['types']}</td>
                <td>{$row['totals']}</td>
                <td>{$row['created_at']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No orders found</td></tr>";
}

    ?>
        </tbody>
    </table>
</div>

<script>
    // Add another item input field
    $(document).on('click', '#addItemButton', function() {
        var newItem = $('.order-item:first').clone(); // Clone the first item row
        newItem.find('input').val(''); // Reset values
        $('.order-items').append(newItem); // Append the new item row
    });

    // Remove an item input field
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.order-item').remove(); // Remove the current item row
    });

    // Submit form using AJAX
    $(document).on('click', '#submitButtonOrder', function() {
        var formData = new FormData($('#orderReportForm')[0]);

        // Serialize the form data and add it to FormData (in case there are additional fields)
        var formSerializedData = $('#orderReportForm').serializeArray();
        formSerializedData.forEach(function(field) {
            formData.append(field.name, field.value);
        });

        $.ajax({
            type: 'POST',
            url: 'submit_order.php', // Ensure this path is correct
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response); // Log the response for debugging
                $('#responseMessage').html('<div class="alert alert-success">Order reported successfully!</div>');
                $('#orderReportForm')[0].reset(); // Reset the form
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error); // Log error for debugging
                $('#responseMessage').html('<div class="alert alert-danger">Error reporting order: ' + error + '</div>');
            }
        });
    });
</script>

</body>
</html>
