<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Procedure</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php
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

// Set default values
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; // Records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page
$offset = ($page - 1) * $limit;

// Get total records
$totalQuery = "SELECT COUNT(*) as total FROM emergency_centers";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch the records
$query = "SELECT * FROM emergency_centers LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>


<div class="emergency-procedure-body">
  <div class="emergency-procedure-buttons">
    <button class='' data-file='securityAndSafety/emergency-procedure.php' onclick='highlightSecondNav(this); loadPHP(this);' style='color: #666CAA;'>EVACUATION CENTER</button>
    <button class='' data-file='securityAndSafety/fire-safety.php' onclick='highlightSecondNav(this); loadPHP(this);'>FIRE SAFETY</button>
  </div>

  <div class="filter-controls">
    <label for="limit">Show:</label>
    <select id="limit" onchange="changeLimit()">
      <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
      <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
      <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
    </select>
  </div>

  <div class="emergency-procedure-table-container">
    <table class="table table-striped emergency-procedure-table">
      <thead>
        <tr>
          <th>Barangay Court</th>
          <th>School</th>
          <th>Church</th>
          <th>Capacity</th>
          <th>Availability</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($center = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($center['barangay_court']); ?></td>
            <td><?php echo htmlspecialchars($center['school']); ?></td>
            <td><?php echo htmlspecialchars($center['church']); ?></td>
            <td><?php echo htmlspecialchars($center['capacity']); ?></td>
            <td><?php echo htmlspecialchars($center['availability']); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
