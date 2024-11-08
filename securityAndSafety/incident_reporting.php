<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Reporting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="incident-reporting-body">
        <form id="incidentReportForm" enctype="multipart/form-data" class="incident-form">    
            <div class="upper-incident">
                <label for="incidentImage" class="incident-form-label">Incident Image</label>
                <input type="file" class="incident-form-input" id="incidentImage" name="incident_image" required>
                <label for="incidentType" class="incident-form-label">Incident Type</label>
                <input type="text" class="incident-form-input" id="incidentType" name="incident_type" required>
            </div>
            <div class="lower-incident">
                <label for="incidentCategory" class="incident-form-label">Incident Category</label>
                <input type="text" class="incident-form-input" id="incidentCategory" name="incident_category" required>
                <label for="incidentDate" class="incident-form-label">Incident Date</label>
                <input type="date" class="incident-form-input" id="incidentDate" name="incident_date" required>
            </div>
                <div class="lower-incident">
                <label for="reportedBy" class="incident-form-label">Reported By</label>
                <input type="text" class="incident-form-input" id="reportedBy" name="reported_by" required>
            </div>

            <button type="button" id="submitButton" class="incident-button" onclick="validateAndSubmit()">Save</button>

        </form>

        <div id="responseMessage" class="mt-3"></div>

        <h3 class="reported-incidents">Reported Incidents</h3>
        <table class="table table-striped mt-3" id="incidentTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>When</th>
                    <th>Reported By</th>
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
                $sql = "SELECT incident_id, incident_image, incident_type, incident_category, incident_date, reported_by, incident_status FROM incident_report_tbl";
                $result = $conn->query($sql);

                // Check if there are results and fetch them
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>' .
                             '<td>' . htmlspecialchars($row["incident_id"]) . '</td>' .
                             '<td><img src="securityAndSafety/' . htmlspecialchars($row["incident_image"]) . '" alt="Incident Image" style="width: 50px; height:50px;"></td>' .
                             '<td>' . htmlspecialchars($row["incident_type"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["incident_category"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["incident_date"]) . '</td>' .
                             '<td>' . htmlspecialchars($row["reported_by"]) . '</td>' .
                             '<td>' .
                             '<select class="form-select status-select" data-id="' . $row["incident_id"] . '">' .
                             '<option value="Open" ' . ($row["incident_status"] == "Open" ? 'selected' : '') . '>Open</option>' .
                             '<option value="In Progress" ' . ($row["incident_status"] == "In Progress" ? 'selected' : '') . '>In Progress</option>' .
                             '<option value="Resolved" ' . ($row["incident_status"] == "Resolved" ? 'selected' : '') . '>Resolved</option>' .
                             '<option value="Closed" ' . ($row["incident_status"] == "Closed" ? 'selected' : '') . '>Closed</option>' .
                             '</select>' .
                             '</td>' .
                             '</tr>';
                    }
                }

                // Close the database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
      
    </script>
</body>
</html>
