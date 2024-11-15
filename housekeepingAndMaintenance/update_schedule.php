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
// Handle POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update status for a specific room
    if (isset($_POST['id'], $_POST['status'])) {
        updateRoomStatus($conn, $_POST['id'], $_POST['status']);
        exit; // Ensure no further code is executed after response
    }
    // Update all cleaning dates
    elseif (isset($_POST['newDate'])) {
        updateAllCleaningDates($conn, $_POST['newDate']);
        exit; // Ensure no further code is executed after response
    }
}

$conn->close();

function updateRoomStatus($conn, $id, $status) {
    // Valid status options
    $validStatuses = ['In Progress', 'Clean', 'Dirty', 'Out of Order'];

    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'error' => 'Invalid status']);
        exit;
    }

    $sql = "UPDATE cleaning_schedules SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('si', $status, $id);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // Optional: Log error (make sure to disable in production or log to a file)
            error_log('Failed to execute statement: ' . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
    } else {
        // Optional: Log error (make sure to disable in production or log to a file)
        error_log('Failed to prepare statement: ' . $conn->error);
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}


function updateAllCleaningDates($conn, $newDate) {
    $sql = "UPDATE cleaning_schedules SET cleaning_date = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $newDate);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            // Optional: Log error (make sure to disable in production or log to a file)
            error_log('Failed to execute statement: ' . $stmt->error);
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
    } else {
        // Optional: Log error (make sure to disable in production or log to a file)
        error_log('Failed to prepare statement: ' . $conn->error);
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}

?>