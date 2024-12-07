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
    // Update status for a specific room
    if (isset($_POST['id'], $_POST['status'])) {
        updateRoomStatus($conn, $_POST['id'], $_POST['status']);
        exit; // Ensure no further code is executed after response
    }
    // Update all cleaning dates
    elseif (isset($_POST['newDate'])) {
        updateAllCleaningDates($conn, $_POST['newDate']);
        exit; // Ensure no further code is executed after response
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

$conn->close();

// Function to update room status
// Function to update room status
function updateRoomStatus($conn, $id, $status) {
    // Validate and sanitize input
    $id = (int)$id; // Ensure $id is an integer
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
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Status updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'error' => 'No rows were updated.']);
            }
        } else {
            logError($stmt->error); // Log error
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement.']);
        }
    } else {
        logError($conn->error); // Log error
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement.']);
    }
}

// Function to update all cleaning dates
function updateAllCleaningDates($conn, $newDate) {
    // Sanitize the new date input
    $newDate = htmlspecialchars(strip_tags($newDate));

    if (empty($newDate)) {
        echo json_encode(['success' => false, 'error' => 'Invalid date.']);
        exit;
    }

    $sql = "UPDATE cleaning_schedules SET cleaning_date = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $newDate);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'All cleaning dates updated successfully.']);
                // Redirect back to the previous page
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;  // Stop further script execution after the redirect
            } else {
                echo json_encode(['success' => false, 'error' => 'No rows were updated.']);
            }
        } else {
            logError($stmt->error); // Log error
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement.']);
        }
    } else {
        logError($conn->error); // Log error
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement.']);
    }
}


?>
