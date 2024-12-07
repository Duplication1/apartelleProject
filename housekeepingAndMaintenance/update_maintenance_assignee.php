<?php
include_once("../connection/connection.php");
$con = connection(); // Use $con consistently

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the required POST data is set
if (isset($_POST['id']) && isset($_POST['assignee']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $assignee = $_POST['assignee'];
    $status = $_POST['status'];

    // Prepare and execute the update statement
    $stmt = $con->prepare("UPDATE maintenance_schedules SET assignee = ?, status = ? WHERE id = ?");
    
    // Assuming id is an integer, use "ssi" for string, string, integer
    $stmt->bind_param("ssi", $assignee, $status, $id);

    if ($stmt->execute()) {
        // Return a success response as JSON
        echo json_encode([
            'success' => true,
            'message' => 'Update successful!'
        ]);
    } else {
        // Return an error response as JSON
        echo json_encode([
            'success' => false,
            'error' => 'Error updating record: ' . $stmt->error
        ]);
    }

    $stmt->close();
} else {
    // Return an error response if required fields are missing
    echo json_encode([
        'success' => false,
        'error' => 'Required fields are missing.'
    ]);
}

// Close the connection
$con->close();
?>
