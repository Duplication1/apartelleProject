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
        if ($row['is_first_login'] == 1) {
            echo "It seems that it is your first time logging in, please use the <a href='adminlogin.php'>default login page</a>";
        } else {
            // Assume the email matches and user is validated
            $_SESSION['user_id'] = $row['email'];  // Set the session variable to user_id
            $_SESSION['email'] = $row['email'];  // Set the session variable to email
            unset($_SESSION['indefinite_lock']);
            unset($_SESSION['lock_time']);

            // Return success if the session is successfully set
            echo "success";
        }
    } else {
        // If no user email is found or something goes wrong
        echo "Email not found or database error.";
    }
} else {
    // If the code is incorrect or the form was not properly submitted
    echo "Invalid request.";
}
?>
