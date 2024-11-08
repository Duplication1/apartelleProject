<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "apartelle_db"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $incidentType = htmlspecialchars(trim($_POST['incident_type']));
    $incidentCategory = htmlspecialchars(trim($_POST['incident_category']));
    $incidentDate = htmlspecialchars(trim($_POST['incident_date']));
    $reportedBy = htmlspecialchars(trim($_POST['reported_by']));

    // Handle file upload
    if (isset($_FILES['incident_image'])) {
        if ($_FILES['incident_image']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";

            // Create directory if it doesn't exist
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Sanitize file name
            $fileName = basename($_FILES["incident_image"]["name"]);
            $fileName = preg_replace("/[^a-zA-Z0-9.]/", "_", $fileName); // Remove unwanted characters
            $fileName = uniqid() . "_" . $fileName; // Add a unique ID to avoid overwriting
            $targetFile = $targetDir . $fileName;

            // Check if the file is an actual image
            $check = getimagesize($_FILES["incident_image"]["tmp_name"]);
            if ($check === false) {
                echo json_encode(["success" => false, "message" => "File is not an image."]);
                exit;
            }

            // Validate file extension
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo json_encode(["success" => false, "message" => "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed."]);
                exit;
            }

            // Move the uploaded file
            if (move_uploaded_file($_FILES["incident_image"]["tmp_name"], $targetFile)) {
                // Prepare the SQL statement
                $stmt = $conn->prepare("INSERT INTO incident_report_tbl (incident_image, incident_type, incident_category, incident_date, reported_by) VALUES (?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sssss", $targetFile, $incidentType, $incidentCategory, $incidentDate, $reportedBy);

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo json_encode(["success" => true, "message" => "Incident reported successfully!"]);
                    } else {
                        echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
                    }

                    $stmt->close();
                } else {
                    echo json_encode(["success" => false, "message" => "Error preparing statement."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Error moving uploaded file."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Error uploading file: " . $_FILES['incident_image']['error']]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No file uploaded."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
