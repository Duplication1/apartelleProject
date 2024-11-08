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
    if (isset($_POST['id'], $_POST['status'])) {
        // Update status for a specific room
        updateRoomStatus($conn, $_POST['id'], $_POST['status']);
    } elseif (isset($_POST['newDate'])) {
        // Update all cleaning dates
        updateAllCleaningDates($conn, $_POST['newDate']);
    }
}

// Close the connection
$conn->close();

/**
 * Update the status of a specific room.
 *
 * @param mysqli $conn Database connection
 * @param int $id Room ID
 * @param string $status New status
 */
function updateRoomStatus($conn, $id, $status) {
    // Valid status options
    $validStatuses = ['In Progress', 'Clean', 'Dirty', 'Out of Order'];

    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'error' => 'Invalid status']);
        exit;
    }

    // Prepare and execute the update statement
    $sql = "UPDATE cleaning_schedules SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}

/**
 * Update all cleaning dates in the database.
 *
 * @param mysqli $conn Database connection
 * @param string $newDate New cleaning date
 */
function updateAllCleaningDates($conn, $newDate) {
    // Prepare and execute the update statement
    $sql = "UPDATE cleaning_schedules SET cleaning_date = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('s', $newDate);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to execute statement']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to prepare statement']);
    }
}
?>
