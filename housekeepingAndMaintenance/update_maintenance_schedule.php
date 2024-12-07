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
    die(json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]));
}

// Handle POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update status for a specific maintenance schedule
    if (isset($_POST['id'], $_POST['status'])) {
        updateMaintenanceStatus($conn, $_POST['id'], $_POST['status']);
        exit; // Ensure no further code is executed after the response
    }
    // Update all scheduled dates for maintenance
    elseif (isset($_POST['newDate'])) {
        updateAllMaintenanceDates($conn, $_POST['newDate']);
        exit; // Ensure no further code is executed after the response
    }
}

$conn->close();

// Function to update maintenance schedule status
function updateMaintenanceStatus($conn, $id, $status) {
    // Valid status options for maintenance
    $validStatuses = ['Pending', 'In Progress', 'Completed', 'On Hold'];

    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'error' => 'Invalid status']);
        exit;
    }

    // Prepare SQL statement to update the maintenance schedule status
    $sql = "UPDATE maintenance_schedules SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('si', $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // Log error (optional)
            error_log('Failed to execute statement: ' . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
    } else {
        // Log error (optional)
        error_log('Failed to prepare statement: ' . $conn->error);
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}

// Function to update all maintenance scheduled dates
function updateAllMaintenanceDates($conn, $newDate) {
    // Prepare SQL statement to update all maintenance scheduled dates
    $sql = "UPDATE maintenance_schedules SET scheduled_date = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $newDate);
        if ($stmt->execute()) {
            // If the update is successful, send a redirect header
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit; // Make sure no further code is executed after the redirect
        } else {
            // Log error (optional)
            error_log('Failed to execute statement: ' . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
    } else {
        // Log error (optional)
        error_log('Failed to prepare statement: ' . $conn->error);
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}

?>
