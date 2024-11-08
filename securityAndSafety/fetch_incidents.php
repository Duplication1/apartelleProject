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
$sql = "SELECT incident_image, incident_type, incident_category, incident_date, reported_by FROM incident_report_tbl";
$result = $conn->query($sql);

// Check if there are results and fetch them
$incidents = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $incidents[] = $row;
    }
}

// Close the database connection
$conn->close();

// Output incidents in JSON format
header('Content-Type: application/json'); // Set the content type to JSON
echo json_encode($incidents);
?>