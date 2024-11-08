<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="resources-allocation-body">
    <div class="container pt-5">
    <table id="resourceTable" class="table table-striped resource-table" style="width:100%">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Location</th>
                <th>Capacity</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
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

            // SQL query to fetch data from resource_allocation_tbl
            $sql = "SELECT resource_id, stock_id, item_name, location, capacity, availability FROM resource_allocation_tbl";
            $result = $conn->query($sql);

            // Check if data is available
            if ($result->num_rows > 0) {
                // Loop through data and display each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['item_name']) . "</td>
                            <td>" . htmlspecialchars($row['location']) . "</td>
                            <td>" . htmlspecialchars($row['capacity']) . "</td>
                            <td>" . htmlspecialchars($row['availability']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data available</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>


    </div>
    <script>
    // Initialize DataTables
    $(document).ready(function() {
        $('#resourceTable').DataTable();
    });
</script>
</body>
</html>