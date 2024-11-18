<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Order Form</h2>
    <form id="orderReportForm" enctype="multipart/form-data" class="order-form">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="orderItemName" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="orderItemName" name="item_name" required>
            </div>
            <div class="col-md-6">
                <label for="orderQuantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="orderQuantity" name="quantity" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="orderPrice" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" id="orderPrice" name="price" required>
            </div>
            <div class="col-md-6">
                <label for="orderDate" class="form-label">Order Date</label>
                <input type="date" class="form-control" id="orderDate" name="created_at" required>
            </div>
        </div>

        <div class="d-flex justify-content-start">
            <button type="button" id="submitButtonOrder" class="btn btn-primary" onclick="validateAndSubmit()">Save</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    // Your validation and submission logic can go here
</script>

</body>
</html>


        <div id="responseMessage" class="mt-3"></div>

        <h3 class="reported-orders">Reported Orders</h3>
        <table class="table table-striped mt-3" id="orderTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to your database
                $servername = "localhost";
                $username = "root"; // Your database username
                $password = ""; // Your database password
                $dbname = "apartelle_db"; // Your database name

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and execute the SQL statement
                $sql = "SELECT order_id, item_name, quantity, price, (quantity * price) AS total_price, created_at, status FROM order_requests";
                $result = $conn->query($sql);

                // Check if there are results and fetch them
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>' .
                             '<td>' . htmlspecialchars($row["order_id"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["item_name"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["quantity"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["price"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["total_price"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["created_at"]) . '</td>' .
                             '<td>' . 
                             // Display static status
                             '<span class="badge bg-' . getStatusBadgeClass($row["status"]) . '">' . htmlspecialchars($row["status"]) . '</span>' . 
                             '</td>' .
                             '</tr>';
                    }
                }

                // Close the database connection
                $conn->close();

                // Function to get the Bootstrap class for each status
                function getStatusBadgeClass($status) {
                    switch($status) {
                        case 'Pending':
                            return 'secondary';
                        case 'Processing':
                            return 'primary';
                        case 'Shipped':
                            return 'warning';
                        case 'Delivered':
                            return 'success';
                        default:
                            return 'light';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        // Your existing AJAX code can remain here
    </script>
</body>
</html>
