<?php
session_start(); // Start the session

// Database connection
$conn = new mysqli('localhost', 'root', '', 'apartelle_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in employee's first and middle name from the session
if (isset($_SESSION['employee_id'])) {
    $employee_id = $_SESSION['employee_id'];

    // Query to get the first, middle, and last name of the employee (evaluator)
    $employeeQuery = "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname) AS evaluator_name FROM employee_tbl WHERE employee_id = ?";
    $stmt = $conn->prepare($employeeQuery);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();
    $evaluator_name = $employee['evaluator_name'];
} else {
    $evaluator_name = 'Unknown'; // Default if no session is set
}

// Fetch evaluations from the database
$sql = "
    SELECT 
        ev.evaluation_id,
        CONCAT(e.firstname, ' ', e.middlename, ' ', e.lastname) AS full_name,
        ev.evaluation_date,
        ev.remarks
    FROM evaluation_tbl ev
    JOIN employee_tbl e ON ev.employee_id = e.employee_id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Evaluations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>
<body>


<div class="emergency-procedure-buttons">
    <button class='' data-file='productionSchedulingAndControl/performance_monitoring.php' onclick=' loadPHP(this); ' >CUSTOMER</button>
    <button class='' data-file='productionSchedulingAndControl/employee_monitoring.php' onclick=' loadPHP(this);' style='color: #666CAA;'>EMPLOYEE</button>
    <button class='' data-file='productionSchedulingAndControl/inventory_monitoring.php' onclick=' loadPHP(this);'>INVENTORY</button>
  </div>
    <h2>Update Evaluations</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Evaluation Date</th>
                <th>Remarks</th>
                <th>Evaluator Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $evaluation_id = $row['evaluation_id'];
                    $full_name = $row['full_name'];
                    $evaluation_date = $row['evaluation_date'];
                    $remarks = $row['remarks'];
            ?>
            <tr data-id="<?php echo $evaluation_id; ?>">
                <td><?php echo $full_name; ?></td>
                <td>
                    <input type="date" name="evaluation_date_<?php echo $evaluation_id; ?>" value="<?php echo date('Y-m-d', strtotime($evaluation_date)); ?>" class="form-control">
                </td>
                <td>
                    <input type="text" name="remarks_<?php echo $evaluation_id; ?>" value="<?php echo htmlspecialchars($remarks); ?>" class="form-control">
                </td>
                <td>
                    <input type="text" name="evaluator_name_<?php echo $evaluation_id; ?>" value="<?php echo htmlspecialchars($evaluator_name); ?>" class="form-control" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-primary update-evaluation-btn" data-id="<?php echo $evaluation_id; ?>">Update</button>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='5'>No evaluations found</td></tr>";
            }
            ?>
        </tbody>
    </table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

</script>

</body>
</html>

<?php
$conn->close();
?>
