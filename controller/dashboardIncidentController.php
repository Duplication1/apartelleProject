<?php
function fetchIncidentReports() {
    $conn = dbConnect();
    $sql = "SELECT incident_image, incident_status FROM incident_report_tbl";  // Modify table name and fields as needed
    $result = $conn->query($sql);

    $reports = [];
    if ($result->num_rows > 0) {
        // Fetch all rows as an associative array
        while($row = $result->fetch_assoc()) {
            $reports[] = $row;
        }
    }
    $conn->close();
    return $reports;
}

// 3. Display data in a Bootstrap striped table
function displayIncidentReportsTable() {
    $reports = fetchIncidentReports();
    if (empty($reports)) {
        echo "<p>No incident reports available.</p>";
        return;
    }

    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Incident Image</th><th>Incident Status</th></tr></thead>';
    echo '<tbody>';

    // Loop through the data and display each row
    foreach ($reports as $report) {
        echo '<tr>';
        
        // Display the image with a thumbnail
        echo '<td><img src="securityAndSafety/' . htmlspecialchars($report["incident_image"]) . '" alt="Incident Image" style="width: 50px; height:50px;"></td>' ;
        
        // Display the incident status
        echo '<td>' . htmlspecialchars($report['incident_status']) . '</td>';
        
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}
?>