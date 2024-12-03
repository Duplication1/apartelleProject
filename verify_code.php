<?php
session_start();
include_once("connection/connection.php");

$con = connection();  // Assuming the database connection function

// Check if the code is correct
if (isset($_POST['code_verified']) && isset($_SESSION['login_code']) && $_POST['code_verified'] == 'true') {
    // Assuming you fetch the user email from the database to verify the user's identity
    $sql = "SELECT email FROM manager_tbl WHERE job = 'om' LIMIT 1";
    $result = $con->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        // Assume the email matches and user is validated
        $_SESSION['user_id'] = $row['email'];  // Set the session variable to user_id
        $_SESSION['email'] = $row['email'];  // Set the session variable to email
        unset($_SESSION['indefinite_lock']);

        // Return success if the session is successfully set
        echo "success";
    } else {
        // If no admin email is found or something goes wrong
        echo "User email not found or database error.";
    }
} else {
    // If the code is incorrect or the form was not properly submitted
    echo "Invalid request.";
}
?>
