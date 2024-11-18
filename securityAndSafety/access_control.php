<?php
session_start();
// Include the database connection
include '../connection/connection.php';

// Fetch time logs for the admin user
// SQL Query to join admin_time_logs with user_tbl to get the email
$sql = "SELECT u.email, u.pass, at.login_time 
        FROM admin_time_logs at
        JOIN user_tbl u ON at.admin_id = u.employee_id
        WHERE at.admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['employee_id']);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StocksLevel</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<!-- Access Control Section -->
<div class="container mt-5">
   
<!-- Time Log Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Time Log</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Check if there are results
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<th scope='row'>" . htmlspecialchars($row['email']) . "</th>";
                echo "<td>" . htmlspecialchars($row['pass']) . "</td>";
                echo "<td>" . htmlspecialchars($row['login_time']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>
    </tbody>
</table>


<!-- JavaScript -->
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

<script>
    function updateButton(value) {
        document.getElementById('dropdownMenuButton').innerText = value;
    }
</script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
