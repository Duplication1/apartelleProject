
<?php
include_once("../connection/connection.php");
$con = connection();

// Check if the required POST parameters are set
if (isset($_POST['id']) && isset($_POST['location']) && isset($_POST['schedule_date']) && isset($_POST['assignee'])) {
    $id = $_POST['id'];
    $location = $_POST['location'];
    $schedule_date = $_POST['schedule_date'];
    $assignee = $_POST['assignee']; // Get the assignee from the POST data

    // Debugging output
    error_log("ID: $id, Location: $location, Schedule Date: $schedule_date, Assignee: $assignee");

    // Check if the record exists
    $result = $con->query("SELECT * FROM security_schedules WHERE id = $id");
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'No record found with this ID.']);
        exit;
    }

    // Prepare and execute the update statement
    $stmt = $con->prepare("UPDATE security_schedules SET location = ?, schedule_date = ?, assignee = ? WHERE id = ?");
    $stmt->bind_param("sssi", $location, $schedule_date, $assignee, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Schedule updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No rows updated. Check if the data is the same as before.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule: ' . $stmt->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
}

$stmt->close();
$con->close();
?>